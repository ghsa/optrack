<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LiliControl\LiliModel;

class UserOption extends LiliModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'option_id',
        'amount',
        'sell_price',
        'buy_price',
        'sell_date',
        'buy_date',
        'obs',
        'starts',
        'open'
    ];

    const RECOMENDATION_BUY = 'Recomprar';
    const RECOMENDATION_WAIT = 'Esperar';
    const RECOMENDATION_ROLL = 'Rolagem';

    public static  $recomendationClass = [
        self::RECOMENDATION_WAIT => 'primary',
        self::RECOMENDATION_BUY => 'success',
        self::RECOMENDATION_ROLL => 'warning',
    ];

    public static $openStatus = [
        1 => "Aberto",
        0 => "Fechado"
    ];

    public function getValidationFields()
    {
        return [
            'option_id' => 'required',
            'amount' => 'required',
            'sell_price' => 'required'
        ];
    }

    public function getProftPercentage()
    {
        return ($this->sell_price / $this->option->strike) * 100;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function getRecomendation()
    {
        if ($this->option->price <= ($this->sell_price * config('app.buy_percentage'))) {
            return self::RECOMENDATION_BUY;
        } else if ($this->option->days_to_maturity > config('app.days_to_roll')) {
            return self::RECOMENDATION_WAIT;
        } else {
            return self::RECOMENDATION_ROLL;
        }
    }

    public function getResult()
    {
        if ($this->open) {
            return (($this->sell_price - $this->option->price));
        }
        return (($this->sell_price - $this->buy_price));
    }
}
