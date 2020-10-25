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

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function isITM()
    {
        if (($this->type == 'CALL' && $this->strike <= $this->stock->current_price)
            || $this->type == 'PUT' && $this->strike >= $this->stock->current_price
        ) {
            return true;
        }
        return false;
    }
}
