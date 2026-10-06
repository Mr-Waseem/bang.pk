<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleTax extends Model
{
	protected $fillable = [
		'party_id', 'unregistered_cnicntn', 'warehouse_id', 'date', 'sale_type', 'invoice_no', 'scenario_id', 'fbr_invoice_no', 'dcn_no', 'p_order', 'remarks',
		'biller', 'company_id', 'ref_usin', 'advance_income_tax', 'total_income_tax', 'discount_amount', 'withheld_at_source', 'petroleum_levy_rate', 'withheld_at_source_amount', 'customer_name', 'customer_cnic'
	];

	public function saletax_details()
	{
		return $this->hasMany('App\Models\SaleTaxDetails', 'sale_id');
	}

	public function products()
	{
		return $this->belongsTo('App\Models\Product', 'product_id');
	}

	public function parties()
	{
		return $this->belongsTo('App\Models\Party', 'party_id');
	}

	public function billers()
	{
		return $this->belongsTo('App\Models\User', 'biller');
	}

	public function shop()
	{
		return $this->belongsTo('App\Models\Warehouse', 'warehouse_id');
	}

	       public function general_vouchers()
    {
        return $this->hasMany('App\Models\GeneralVoucher', 'transaction_id');
    }
}
