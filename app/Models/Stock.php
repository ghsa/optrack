<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use LiliControl\LiliModel;

class Stock extends LiliModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'image',
        'initials',
        'buy_price',
        'amount',
        'fundamentalist_price',
        'current_price',
        'short_trend',
        'middle_trend',
        'current_iv',
        'last_api_update',
        'variation',
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
            'name' => 'required',
            'initials' => 'required',
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
}
