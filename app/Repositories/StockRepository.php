<?php

namespace App\Repositories;

use App\Jobs\UpdateStockOptionsJob;
use App\Models\Stock;
use App\Services\StockTrackerInterface;

class StockRepositories
{

    public function updateStockInformation(Stock $stock, $info)
    {
        dump($info);
        $stock->current_price = $info['close'];
        $stock->short_trend = $info['short-term-trend'];
        $stock->middle_trend = $info['middle-term-trend'];
        $stock->current_iv = $info['iv-current'];
        $stock->last_api_update = date('Y-m-d H:i:s');
        $stock->variation = $info['variation'];
        $stock->save();
    }

    public function updateAllStocks()
    {
        $stocks = Stock::get();
        $accessToken = app(StockTrackerInterface::class)->getAccessToken();
        foreach ($stocks as $stock) {
            dispatch(new UpdateStockOptionsJob($accessToken, $stock));
        }
    }
}
