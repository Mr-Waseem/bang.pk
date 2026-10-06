<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
	protected $fillable = [
		'account_group_id', 'account_type', 'code', 'party_name', 'location_id', 'cnic', 'customer_type', 'province', 'bank_id',
		'bank_account_no', 'shop_id', 'phone', 'ntn', 'strn', 'city', 'address', 'salary', 'employee_status',
		'fatrate', 'company_id', 'designation', 'basic_salary', 'allowance', 'deduction', 'net_salary',
		'status', 'salary_status'
	];



	public function purchase_detail()
	{
		return $this->hasMany('App\Models\PurchaseDetail');
	}

	public function sale_detail()
	{
		return $this->hasMany('App\Models\SaleDetail');
	}

	public function purchase_return_detail()
	{
		return $this->hasMany('App\Models\PurchaseReturnDetails');
	}

	public function sale_return_detail()
	{
		return $this->hasMany('App\Models\SaleReturnDetails');
	}

	public function products()
	{
		return $this->hasMany('App\Models\Product');
	}

	public function attendance_details()
	{
		return $this->hasMany('App\Models\AttendanceDetails', 'employee_id');
	}




	public function bank_payments()
	{
		return $this->hasMany('App\Models\BankPayment', 'account_head_id');
	}

	public function cash_receipts()
	{
		return $this->hasMany('App\Models\CashReceipt', 'account_head_id');
	}

	public function cash_payments()
	{
		return $this->hasMany('App\Models\CashPayment', 'account_head_id');
	}

	public function cheque_payments()
	{
		return $this->hasMany('App\Models\ChequePayment', 'account_head_id');
	}

	public function purchase_milk()
	{
		return $this->hasMany('App\Models\PurchaseMilk', 'supplier_id');
	}


	public function milk_collection()
	{
		return $this->hasMany('App\Models\CollectionMilk', 'supplier_id');
	}

	public function milk_location()
	{
		return $this->hasMany('App\Models\CollectionMilk', 'location_id');
	}

	public function ledger()
	{
		return $this->hasMany('App\Models\GeneralVoucher', 'account_head_id');
	}

	public function general_vouchers()
	{
		return $this->hasMany('App\Models\GeneralVoucher', 'account_head_id');
	}

	public function location()
	{
		return $this->belongsTo('App\Models\AccountGroup', 'location_id');
	}

	public function bank()
	{
		return $this->belongsTo('App\Models\Banks', 'bank_id');
	}

	public function shop()
	{
		return $this->belongsTo('App\Models\Warehouse', 'shop_id');
	}
}
