<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    protected $fillable = array('CompanyName', 'phone','category','system_type', 'address', 'status','ntn','strn','pos_id','type','bill_type','ntn_show','strn_show','sandbox_token','token',
    'footer_show', 'discount', 'discount2', 'discount_fixed', 'discount_fixed2', 'invoiceno_prefix', 'invoice_qrcode', 'invoice_serial', 'approval', 'extra_tax','start_date','expire_date','province','client_payment','payment_terms', 'invoice_type', 'sale_type', 'scenario', 'number_of_invoices', 'partner_id', 'st_held', 'fed_payable', 'invoice_design', 'contact_person', 'contact_person_phone', 'contact_person_email', 'contact_person_address', 'tax_on_invoice', 'invoice_header', 'white_label', 'debug_mode', 
	'show_unit', 'show_fbr_qty', 'custom_heading', 'company_logo', 'is_active', 'created_by', 'updated_by');

    public function user()
	{
		return $this->hasMany('App\Models\User', 'company_id');
	}

	
	   public function sales()
	{
		return $this->hasMany('App\Models\SaleTax', 'company_id');
	}

        public function partner()
	{
		return $this->belongsTo('App\Models\User', 'partner_id');
	}
}
