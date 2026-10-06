<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
	protected $fillable = [
		'catagory_id',
		'product_code',
		'product_name',
		'uom_id',
		'uom',
		'type',
		'product_cost',
		'product_price',
		'tax',
		'alert',
		'has_recipe',
		'pack_type',
		'pack_weight',
		'company_id'
	];

	public function products_detail()
	{
		return $this->hasMany('App\Models\PurchaseDetail');
	}

	public function production_stockin()
	{
		return $this->hasMany('App\Models\Production', 'products_id');
	}

	public function production()
	{
		return $this->hasMany('App\Models\Production', 'products_id');
		//->groupBy('products_id')
		//->select(DB::raw('SUM(rates) as total'));
	}

	public function production_stockout()
	{
		return $this->hasMany('App\Models\ProductionDetails');
	}

	public function grn_detail()
	{
		return $this->hasMany('App\Models\GRNDetails');
	}
	public function purchase_detail()
	{
		return $this->hasMany('App\Models\PurchaseDetail');
	}

	public function sale_detail()
	{
		return $this->hasMany('App\Models\SaleDetail');
	}

	// public function sale_report()
	//    {

	//        return $this->hasMany('App\SaleDetail');
	//        ->whereDate('sale_details.date', '>=', $fromDate)
	//        ->whereDate('sale_details.date', '>=', $toDate);
	//    }


	public function challan_detail()
	{
		return $this->hasMany('App\Models\DeliveryChallanDetail', 'product_id');
	}

	public function sale_return_detail()
	{
		return $this->hasMany('App\Models\SaleReturnDetails', 'product_id');
	}

	public function purchase_return_detail()
	{
		return $this->hasMany('App\Models\PurchaseReturnDetails', 'product_id');
	}

	public function publisher_detail()
	{
		return $this->BelongsTO('App\Models\Publisher', 'publisher_id');
	}

	public function publishers()
	{
		return $this->BelongsTo('App\Models\Publisher', 'publisher_id');
	}

	public function catagories()
	{
		return $this->BelongsTo('App\Models\Catagory', 'catagory_id');
	}

	public function party()
	{
		return $this->hasMany('App\Models\Party', 'account_group_id');
	}

	public function stock_transfer_detail()
	{
		return $this->hasMany('App\Models\SaleDetail');
	}

	public function rawmaterial_stock()
	{
		return $this->hasMany('App\Models\RawMaterialStock', 'product_id');
	}

	public function saletax_details()
	{
		return $this->hasMany('App\Models\SaleTaxDetails', 'product_id');
	}

}
