<?php

namespace App\Exports;

use App\Models\SaleTax;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportSalesTaxReport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    private $tax = '';
    private $fromDate = '';
    private $toDate = '';
    
    public function __construct($fromDate, $toDate, $tax)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->tax = $tax;
    }
    
    public function collection()
    {
        $sales = DB::table('sale_taxes')
            ->join('sale_tax_details', 'sale_tax_details.sale_id', '=', 'sale_taxes.id')
            ->join('parties', 'parties.id', '=', 'sale_tax_details.party_id')
            ->join('products', 'products.id', '=', 'sale_tax_details.product_id')
            ->where('sale_taxes.sale_type', 'SalesTax Invoice')
            // ->when($tax != 0, function ($query) use ($tax) {  // Using when() instead of if
            //     $query->where('sale_tax_details.stvalue', $tax);
            // })
          ->when($this->tax != 1000 && $this->tax != 0, function ($query) {
                $query->where('sale_tax_details.stvalue', $this->tax);
            })
            ->whereDate('sale_taxes.date', '>=', $this->fromDate)
            ->whereDate('sale_taxes.date', '<=', $this->toDate)
            ->where('sale_tax_details.company_id', session()->get('company_id'))
            ->orderBy('sale_taxes.id', 'asc')
            ->get([
                DB::raw('DATE_FORMAT(sale_taxes.date, "%d-%M-%y") as date'),
                'sale_taxes.invoice_no',
                'sale_taxes.fbr_invoice_no',
                'parties.ntn',
                'parties.party_name',
                'products.product_code',
                'products.product_name',
                'products.uom',
                'sale_tax_details.quantity',
                'sale_tax_details.rate',
                'sale_tax_details.price',
                'sale_tax_details.stvalue',
                DB::raw('sale_tax_details.total - sale_tax_details.price as tax_value'),
                'sale_tax_details.total'
            ]);
        
        return $sales;
    }

    /**
     * Map each row data
     *
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        // Format the product code (HS Code)
        $productCode = $this->formatProductCode($row->product_code);
        
        return [
            $row->date,
            $row->invoice_no,
            $row->fbr_invoice_no,
            $row->ntn,
            $row->party_name,
            $productCode, // Formatted product code
            $row->product_name,
            $row->uom,
            $row->quantity,
            $row->rate,
            $row->price,
            $row->stvalue,
            $row->tax_value,
            $row->total
        ];
    }

    /**
     * Format product code
     *
     * @param mixed $productCode
     * @return string
     */
    private function formatProductCode($productCode): string
    {
        // If the product code is numeric, format it with 4 decimal places
        if (is_numeric($productCode)) {
            return number_format((float) $productCode, 4, '.', '');
        }
        
        // If it's already a string, return as is
        return (string) $productCode;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return [
            'Date', 
            "Invoice #", 
            "FBR Invoice #", 
            "NTN", 
            "Party Name", 
            "HS Code", 
            "Description", 
            "UOM", 
            "QTY",
            "Rate",
            "Exc.Value", 
            "Tax%", 
            "Tax Value", 
            "Inc.Value"
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:M1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('DCE6F1');
                    
                // Optional: Auto-size columns for better readability
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('I')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('J')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('K')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('L')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('M')->setAutoSize(true);
            },
        ];
    }
}