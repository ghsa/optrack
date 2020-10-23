<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use LiliControl\LiliModel;

class UserStock extends LiliModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stock_id',
        'buy_price',
        'amount',
        'fundamentalist_price',
    ];

    const TREND_HIGH = 1;
    const TREND_NONE = 0;

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }

    public function getValidationFields()
    {
        return [
            'stock_id' => 'required',
        ];
    }

    public function getImageProperties()
    {
        return [
            'image' => ['width' => 200, 'height' => 200, 'quality' => 70]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
