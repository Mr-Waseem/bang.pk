<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HScodes extends Model
{
    use HasFactory;
    protected $fillable = ['hscode', 'description'];
}
