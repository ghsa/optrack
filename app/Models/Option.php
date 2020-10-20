<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'name',
        'type',
        'due_date',
        'days_to_maturity',
        'strike',
        'price',
        'spot_price',
        'volume',
        'volatility',
        'variation'
    ];
}
