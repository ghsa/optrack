<?php

namespace App\Services;

use App\Models\Stock;

interface StockTrackerInterface
{
    public function getAccessToken();

    public function getStock(string $accessToken, Stock $stock);
}
