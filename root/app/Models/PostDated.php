<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostDated extends Model
{
    protected $table = "post-dated";
    protected $fillable = ['account_id', 'voucher_no', 'voucher_date', 'v_type', 'biller', 'status'];

    public function party()
    {
        return $this->BelongsTo('App\Models\Party', 'account_id');
    }

    public function cheque_details()
    {
        return $this->hasMany('App\Models\PostDateCheque', 'voucher_id');
    }
}
