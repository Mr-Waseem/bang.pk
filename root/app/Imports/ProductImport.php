<?php
namespace App\Imports;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Departments;
use App\Models\Catagory;
use App\Models\Companies;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Auth;
class ProductImport implements ToModel, WithValidation, WithStartRow, SkipsOnFailure
{
    public $failures = [];

    /**
     * Start importing from row 2 (skip header row)
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Current logged-in user's company (not session company_id).
     */
    private function currentCompany(): ?Companies
    {
        $companyId = Auth::user()->company_id ?? null;
        if (empty($companyId)) {
            return null;
        }

        return Companies::find($companyId);
    }

    private function currentCompanyId()
    {
        return Auth::user()->company_id ?? null;
    }

    /**
     * POS / PRA / KPRA / SRB keep sheet value as-is.
     * Digital Invoice (FBR) keeps XXXX.XXXX format.
     */
    private function shouldFormatAsHsCode(?Companies $company): bool
    {
        if (!$company) {
            return true;
        }

        return !in_array($company->system_type, ['POS', 'PRA', 'KPRA', 'SRB'], true);
    }

    private function resolveProductCode($code, ?Companies $company = null): string
    {
        $company = $company ?: $this->currentCompany();

        if (!$this->shouldFormatAsHsCode($company)) {
            return trim((string) $code);
        }

        return $this->formatHSCode($code);
    }

    /**
     * Format HS Code to XXXX.XXXX format (8 digits total)
     */
    private function formatHSCode($code)
    {
        // Convert to float and format with 4 decimal places
        $formatted = number_format(floatval($code), 4, '.', '');
        
        // Split into integer and decimal parts
        $parts = explode('.', $formatted);
        
        // Pad integer part to 4 digits (left pad with zeros)
        $integerPart = str_pad($parts[0], 4, '0', STR_PAD_LEFT);
        
        // Decimal part is already 4 digits from number_format
        $decimalPart = $parts[1];
        
        // Ensure integer part is exactly 4 digits (in case of overflow)
        if (strlen($integerPart) > 4) {
            $integerPart = substr($integerPart, -4);
        }
        
        return $integerPart . '.' . $decimalPart;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function rules(): array
    {
        $companyId = $this->currentCompanyId();

        return [
            '0' => [
                'required',
                function ($attribute, $value, $fail) {
                    $company = $this->currentCompany();

                    // Skip HS code existence check for non-digital-invoice types
                    if ($company && !$this->shouldFormatAsHsCode($company)) {
                        return;
                    }

                    $formattedCode = $this->formatHSCode($value);
                    $exists = DB::table('h_scodes')
                        ->where('hscode', $formattedCode)
                        ->exists();
                    
                    if (!$exists) {
                        $fail("HS Code {$formattedCode} does not exist in the system.");
                    }
                },
            ],
            '1' => [
                'required',
                Rule::unique('products', 'product_name')->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId);
                })
            ]
        ];
    }
    
    public function customValidationMessages()
    {
        return [
            '0.required' => 'HS Code is required.',
            '0.exists' => 'HS Code does not exist in the system.',
            '1.unique' => 'Product Already Exist in your company.',
            '1.required' => 'Product name is required.',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        $this->failures = array_merge($this->failures, $failures);
    }

    public function model(array $row)
    {
        if ($row[0] == null) {
            return null;
        }

        $company = $this->currentCompany();
        $productCode = $this->resolveProductCode($row[0], $company);

        return new Product([
            'catagory_id'  => 5,
            'product_code'  => $productCode,
            'product_name'  => $row[1],
            'uom'  => $row[2],
            'product_cost'  => $row[3],
            'product_price'  => $row[4],
            'tax'  => $row[5],
            'company_id'  => $this->currentCompanyId(),
            'has_recipe'  => 0,
            'created_by'  => Auth::User()->id,
        ]);
    }
}
