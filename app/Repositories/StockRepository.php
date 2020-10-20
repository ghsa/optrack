<?php

namespace App\Repositories;

use App\Jobs\UpdateStockOptionsJob;
use App\Models\Stock;
use App\Scopes\UserScope;

class StockRepositories
{

    public function updateStockInformation(Stock $stock, $info)
    {
        $stock->short_trend = $info['short-term-trend'];
        $stock->middle_trend = $info['middle-term-trend'];
        $stock->current_iv = $info['iv-current'];
        $stock->last_ip_update = date('Y-m-d H:i:s');
        $stock->variation = $info['variation'];
        $stock->save();
    }


    public function updateAllStocks()
    {
        $stocks = Stock::withoutGlobalScope(UserScope::class)->get();
        foreach ($stocks as $stock) {
            dispatch(new UpdateStockOptionsJob($stock));
        }
    }
}
