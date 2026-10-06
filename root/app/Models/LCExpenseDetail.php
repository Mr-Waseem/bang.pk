<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LCExpenseDetail extends Model
{
    protected $table = "lc_expense_details";
    protected $fillable = ['lc_expense_id', 'party_id', 'desc', 'receipt'];
}
