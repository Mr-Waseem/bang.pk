<?php

namespace App\Imports;

use App\Models\Party;
use App\Models\User;
use App\Models\AccountGroup3;
use Maatwebsite\Excel\Concerns\ToModel;
use Auth;
class CustomerPartyImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // return $row;
        if($row[0] != "Customer Name" && $row[0] !=null){

            $LastProduct = Party::where('company_id', session()->get('company_id'))->Orderby('id', 'desc')->first(); //11
            $CalculatedCode = 1;
            if($LastProduct){
                $CalculatedCode = $LastProduct->code+1;
            }
            
        return new Party([ 
            'account_group_id'  => 1,
            'party_name'  => $row[0],
            'account_type'  => $row[1],
            'code' => $CalculatedCode,
            'customer_type' => $row[2],
            'province' => $row[3],
            'phone'  => $row[4],
            'ntn'  => $row[5],
            'address'  => $row[6],
            'company_id'  => session()->get('company_id')
        ]);
        }
    }
}
