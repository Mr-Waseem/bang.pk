<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralVoucher extends Model
{
    protected $fillable = [
        'transaction_id', 'account_head_id','head_id', 'attendance_id',  'warehouse_id', 
        'date', 'voucher_no', 'invoice_no', 'cheque_no', 'v_type', 'narration', 'debit', 
        'credit', 'company_id','tax'];


    public function banks()
    {
        return $this->BelongsTo('App\Models\Banks', 'bank_id');
    }

    public function collection_milk()
    {
        return $this->BelongsTo('App\Models\CollectionMilk', 'purchase_milk_id');
    }

    public function parties()
    {
        return $this->belongsTo('App\Models\Party', 'account_head_id');

        // return $this->BelongsTo('App\Models\Party', 'account_head_id')->where('account_group_id', '=', '1')->get();
    }

    public function newparty()
    {
        return $this->belongsTo('App\Models\Party', 'head_id');
    }

        public function sales_tax()
    {
        return $this->belongsTo('App\Models\SaleTax', 'transaction_id');
    }
}
