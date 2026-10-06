<?php

namespace App\Exports;

use App\Models\SaleTax;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportSalesTaxReport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    private $fromDate = '';
    private $toDate = '';
    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }
    public function collection()
    {
        $sales = DB::table('sale_taxes')
            ->join('sale_tax_details', 'sale_tax_details.sale_id', '=', 'sale_taxes.id')
            ->join('parties', 'parties.id', '=', 'sale_tax_details.party_id')
            ->join('products', 'products.id', '=', 'sale_tax_details.product_id')
            ->where('sale_taxes.sale_type', 'SalesTax Invoice')
            ->whereDate('sale_taxes.date', '>=', $this->fromDate)
            ->whereDate('sale_taxes.date', '<=', $this->toDate)
            ->where('sale_tax_details.company_id',session()->get('company_id'))
            ->OrderBy('sale_taxes.id', 'asc')
            ->get([
                DB::raw('DATE_FORMAT(sale_taxes.date, "%d-%M-%y") as date'),
                'sale_taxes.invoice_no',
                'parties.ntn',
                'parties.party_name',
                'products.product_code',
                'products.product_name',
                'products.uom',
                'sale_tax_details.quantity',
                'sale_tax_details.rate',
                'sale_tax_details.price',
                'sale_tax_details.stvalue',
                DB::raw('sale_tax_details.total-sale_tax_details.price'),
                'sale_tax_details.total'
            ]);
        return $sales;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ['Date', "INV.NO", "NTN", "Party Name", "HS Code", "Description", "UOM", "QTY","Rate","Exc.Value", "Tax%", "Tax Value", "Inc.Value"];
        // return ["Date", "INV.NO", "NTN", "Ex.Value", "17% Tax", "En.Value", "Party Name", "QTY"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // $event->sheet->getDelegate()->freezePane('A2');
                $event->sheet->getDelegate()->getStyle('A1:H1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('DCE6F1');
            },
        ];
    }
}
