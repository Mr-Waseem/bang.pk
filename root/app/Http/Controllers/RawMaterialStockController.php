<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RawMaterialStock;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class RawMaterialStockController extends Controller
{
    private const OPENING_STOCK_TYPE = 'OPENING STOCK';

    public function index()
    {
        $products = Product::OrderBy('product_name', 'asc')->where('catagory_id', 5)->where('company_id', session()->get('company_id'))->pluck('product_name', 'id')->prepend('ALL PRODUCTS', '0')->toArray();
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('warehouse-stock-report.stock.raw-create', Compact('products', 'warehouse', 'encrypted_token'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $ProductID = $request->get('product_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $reportType = $request->get('report_type', 'product_wise');
        $companyId = (int) session()->get('company_id');
        $company_detail = Setting::where('id', '=', 1)->get();

        $this->syncMissingPurchaseTaxStocks($companyId);
        $this->syncSalesTaxStockOut($companyId);

        if ($ProductID == "0") {
            $productStock = $this->buildProductStockSummary($companyId, $fromDate, $toDate);

            if ($reportType === 'hs_code_wise') {
                $RawMaterial = $productStock
                    ->groupBy('product_code')
                    ->map(function ($items) {
                        $first = $items->first();
                        return (object) [
                            'product_id' => $first->product_id,
                            'product_code' => $first->product_code,
                            'product_name' => $first->product_name,
                            'opening_stock' => $items->sum('opening_stock'),
                            'stockin' => $items->sum('stockin'),
                            'stockout' => $items->sum('stockout'),
                            'current_stock' => $items->sum('current_stock'),
                        ];
                    })
                    ->values()
                    ->sortBy('product_name')
                    ->values();

                $openingRates = $this->getOpeningStockRatesByProductCode($companyId);

                foreach ($RawMaterial as $item) {
                    $item->avg_rate = (float)($openingRates[$item->product_code] ?? 0);
                }
            } else {
                $RawMaterial = $productStock->sortBy('product_name')->values();

                $openingRates = $this->getOpeningStockRatesByProductId($companyId);

                foreach ($RawMaterial as $item) {
                    $item->avg_rate = (float)($openingRates[$item->product_id] ?? 0);
                }
            }

            return view('warehouse-stock-report.stock.all', Compact('RawMaterial', 'company_detail', 'fromDate', 'toDate'));
        }

        $items = RawMaterialStock::with('uoms')->with('warehouse')->with('products')->with('parties')
            ->where('product_id', '=', $ProductID)
            ->where('company_id', $companyId)
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->where('type', '!=', self::OPENING_STOCK_TYPE)
            ->orderBy('date', 'asc')
            ->get();

        $openingType = self::OPENING_STOCK_TYPE;
        $openingStock = RawMaterialStock::where('product_id', '=', $ProductID)
            ->where('raw_material_stocks.company_id', $companyId)
            ->where(function ($query) use ($fromDate, $toDate, $openingType) {
                $query->whereDate('date', '<', $fromDate)
                    ->orWhere(function ($inner) use ($fromDate, $toDate, $openingType) {
                        $inner->where('type', $openingType)
                            ->whereDate('date', '>=', $fromDate)
                            ->whereDate('date', '<=', $toDate);
                    });
            })
            ->select(DB::raw('SUM(COALESCE(stockin, 0)) as stockin, SUM(COALESCE(stockout, 0)) as stockout'))
            ->get();
        $product = Product::where('id', '=', $ProductID)->get();

        return view('warehouse-stock-report.stock.single', Compact('items', 'company_detail', 'product', 'fromDate', 'toDate', 'openingStock'));
    }

    /**
     * Build per-product stock summary: opening (pre-fromDate + in-period OPENING STOCK),
     * period movements, and closing balance as of toDate.
     */
    private function buildProductStockSummary(int $companyId, string $fromDate, string $toDate)
    {
        $openingType = self::OPENING_STOCK_TYPE;

        $rows = DB::table('raw_material_stocks as rms')
            ->join('products', 'products.id', '=', 'rms.product_id')
            ->where('rms.company_id', $companyId)
            ->where('products.company_id', $companyId)
            ->where('products.catagory_id', 5)
            ->whereDate('rms.date', '<=', $toDate)
            ->groupBy('rms.product_id', 'products.product_code', 'products.product_name')
            ->select(
                'rms.product_id',
                'products.product_code',
                'products.product_name'
            )
            ->selectRaw(
                'SUM(CASE
                    WHEN rms.date < ?
                        OR (rms.type = ? AND rms.date >= ? AND rms.date <= ?)
                    THEN COALESCE(rms.stockin, 0) ELSE 0 END)
                - SUM(CASE
                    WHEN rms.date < ?
                        OR (rms.type = ? AND rms.date >= ? AND rms.date <= ?)
                    THEN COALESCE(rms.stockout, 0) ELSE 0 END) as opening_stock',
                [$fromDate, $openingType, $fromDate, $toDate, $fromDate, $openingType, $fromDate, $toDate]
            )
            ->selectRaw(
                'SUM(CASE
                    WHEN rms.date >= ? AND rms.date <= ? AND rms.type != ?
                    THEN COALESCE(rms.stockin, 0) ELSE 0 END) as stockin',
                [$fromDate, $toDate, $openingType]
            )
            ->selectRaw(
                'SUM(CASE
                    WHEN rms.date >= ? AND rms.date <= ? AND rms.type != ?
                    THEN COALESCE(rms.stockout, 0) ELSE 0 END) as stockout',
                [$fromDate, $toDate, $openingType]
            )
            ->selectRaw(
                '(SUM(CASE
                    WHEN rms.date < ?
                        OR (rms.type = ? AND rms.date >= ? AND rms.date <= ?)
                    THEN COALESCE(rms.stockin, 0) ELSE 0 END)
                - SUM(CASE
                    WHEN rms.date < ?
                        OR (rms.type = ? AND rms.date >= ? AND rms.date <= ?)
                    THEN COALESCE(rms.stockout, 0) ELSE 0 END)
                + SUM(CASE
                    WHEN rms.date >= ? AND rms.date <= ? AND rms.type != ?
                    THEN COALESCE(rms.stockin, 0) ELSE 0 END)
                - SUM(CASE
                    WHEN rms.date >= ? AND rms.date <= ? AND rms.type != ?
                    THEN COALESCE(rms.stockout, 0) ELSE 0 END)) as current_stock',
                [
                    $fromDate, $openingType, $fromDate, $toDate,
                    $fromDate, $openingType, $fromDate, $toDate,
                    $fromDate, $toDate, $openingType,
                    $fromDate, $toDate, $openingType,
                ]
            )
            ->havingRaw(
                '(SUM(CASE WHEN rms.date >= ? AND rms.date <= ? AND rms.type != ? THEN COALESCE(rms.stockin, 0) ELSE 0 END) > 0
                OR SUM(CASE WHEN rms.date >= ? AND rms.date <= ? AND rms.type != ? THEN COALESCE(rms.stockout, 0) ELSE 0 END) > 0
                OR (SUM(CASE
                    WHEN rms.date < ?
                        OR (rms.type = ? AND rms.date >= ? AND rms.date <= ?)
                    THEN COALESCE(rms.stockin, 0) ELSE 0 END)
                - SUM(CASE
                    WHEN rms.date < ?
                        OR (rms.type = ? AND rms.date >= ? AND rms.date <= ?)
                    THEN COALESCE(rms.stockout, 0) ELSE 0 END)
                + SUM(CASE
                    WHEN rms.date >= ? AND rms.date <= ? AND rms.type != ?
                    THEN COALESCE(rms.stockin, 0) ELSE 0 END)
                - SUM(CASE
                    WHEN rms.date >= ? AND rms.date <= ? AND rms.type != ?
                    THEN COALESCE(rms.stockout, 0) ELSE 0 END)) != 0)',
                [
                    $fromDate, $toDate, $openingType,
                    $fromDate, $toDate, $openingType,
                    $fromDate, $openingType, $fromDate, $toDate,
                    $fromDate, $openingType, $fromDate, $toDate,
                    $fromDate, $toDate, $openingType,
                    $fromDate, $toDate, $openingType,
                ]
            )
            ->get();

        return collect($rows);
    }

    /**
     * Opening stock rate from purchase_details.unit_cost (product_id wise).
     */
    private function getOpeningStockRatesByProductId(int $companyId)
    {
        return DB::table('purchase_details')
            ->join('purchases', 'purchases.id', '=', 'purchase_details.purchase_id')
            ->where('purchases.company_id', $companyId)
            ->where('purchase_details.company_id', $companyId)
            ->where('purchases.purchase_type', 'ADJUST')
            ->groupBy('purchase_details.product_id')
            ->select(
                'purchase_details.product_id',
                DB::raw('
                    COALESCE(
                        SUM(purchase_details.unit_cost * purchase_details.quantity)
                        / NULLIF(SUM(purchase_details.quantity), 0),
                        0
                    ) as avg_rate
                ')
            )
            ->pluck('avg_rate', 'product_id');
    }

    /**
     * Opening stock rate from purchase_details.unit_cost (HS code wise).
     */
    private function getOpeningStockRatesByProductCode(int $companyId)
    {
        return DB::table('purchase_details')
            ->join('purchases', 'purchases.id', '=', 'purchase_details.purchase_id')
            ->join('products', 'products.id', '=', 'purchase_details.product_id')
            ->where('purchases.company_id', $companyId)
            ->where('purchase_details.company_id', $companyId)
            ->where('purchases.purchase_type', 'ADJUST')
            ->groupBy('products.product_code')
            ->select(
                'products.product_code',
                DB::raw('
                    COALESCE(
                        SUM(purchase_details.unit_cost * purchase_details.quantity)
                        / NULLIF(SUM(purchase_details.quantity), 0),
                        0
                    ) as avg_rate
                ')
            )
            ->pluck('avg_rate', 'product_code');
    }

    /**
     * Sales Tax invoices must reduce stock. Move wrongly saved stockin qty to stockout.
     */
    private function syncSalesTaxStockOut(int $companyId): void
    {
        $wrongRows = RawMaterialStock::where('company_id', $companyId)
            ->where('type', 'SalesTax Invoice')
            ->whereNotNull('stockin')
            ->where('stockin', '>', 0)
            ->where(function ($query) {
                $query->whereNull('stockout')->orWhere('stockout', 0);
            })
            ->get();

        foreach ($wrongRows as $stock) {
            $stock->stockout = $stock->stockin;
            $stock->stockin = null;
            $stock->save();
        }
    }

    /**
     * Backfill raw_material_stocks rows for purchase tax vouchers that are missing stock-in entries.
     */
    private function syncMissingPurchaseTaxStocks(int $companyId): void
    {
        $missingRows = DB::table('purchase_tax_details as ptd')
            ->join('purchase_taxes as pt', 'pt.id', '=', 'ptd.purchase_id')
            ->leftJoin('raw_material_stocks as rms', function ($join) {
                $join->on('rms.transction_id', '=', 'pt.id')
                    ->on('rms.product_id', '=', 'ptd.product_id')
                    ->where('rms.type', '=', 'PURCHASE TAX');
            })
            ->where('pt.company_id', $companyId)
            ->where('ptd.company_id', $companyId)
            ->whereNull('rms.id')
            ->select(
                'pt.id as purchase_id',
                'pt.date',
                'pt.invoice_no',
                'pt.party_id',
                'ptd.product_id',
                'ptd.party_id as detail_party_id',
                'ptd.uom_id',
                'ptd.quantity',
                'ptd.total'
            )
            ->get();

        foreach ($missingRows as $row) {
            $stock = new RawMaterialStock();
            $stock->transction_id = $row->purchase_id;
            $stock->type = 'PURCHASE TAX';
            $stock->warehouse_id = 1;
            $stock->party_id = $row->detail_party_id ?: $row->party_id;
            $stock->product_id = $row->product_id;
            $stock->uom_id = $row->uom_id;
            $stock->date = $row->date;
            $stock->voucher_no = $row->invoice_no;
            $stock->cost_amount = $row->total;
            $stock->stockin = $row->quantity;
            $stock->company_id = $companyId;
            $stock->save();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
