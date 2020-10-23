<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LiliControl\LiliModel;

class Stock extends LiliModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'initials',
        'current_price',
        'short_trend',
        'middle_trend',
        'current_iv',
        'last_api_update',
        'variation',
    ];

    const TREND_HIGH = 1;
    const TREND_NONE = 0;

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

    public function getOptions()
    {
        return Option::where('stock_id', $this->id)
            ->orderBy('type')
            ->orderBy('due_date')
            ->orderBy('strike')
            ->get();
    }

    public function getUserStock(User $user)
    {
        return UserStock::where('user_id', $user->id)
            ->where('stock_id', $this->id)
            ->first();
    }
}
