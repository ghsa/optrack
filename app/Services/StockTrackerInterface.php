<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\User;

interface StockTrackerInterface
{
    public function getAccessToken(User $user);

    public function getStock(Stock $stock);
}
