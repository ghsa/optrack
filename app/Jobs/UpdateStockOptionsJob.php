<?php

namespace App\Jobs;

use App\Models\Option;
use App\Models\Stock;
use App\Repositories\StockRepositories;
use App\Services\StockTrackerInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStockOptionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $stock;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stockInfo = app(StockTrackerInterface::class)->getStock($this->stock);
        if ($stockInfo == false || empty($stockInfo['info'])) {
            return false;
        }

        $this->updateStockInformation($stockInfo['info']);
        $this->updateOptionsInformation($stockInfo['series']);
        dd($stockInfo);
    }

    private function updateStockInformation($info)
    {
        app(StockRepositories::class)->updateStockInformation($this->stock, $info);
    }

    private function updateOptionsInformation($series)
    {
        foreach ($series as $serie) {
            foreach ($serie['options'] as $optionName => $option) {
                if ($option['volume'] == 0) {
                    continue;
                }
                $dbOption = Option::where('name', $optionName)
                    ->where('year', date('Y'))
                    ->first();
                if (empty($dbOption)) {
                    $dbOption = new Option();
                    $dbOption->stock_id = $this->stock->id;
                    $dbOption->name = $optionName;
                    $dbOption->year = date('Y');
                    $dbOption->type = $serie['type'];
                }
                $dbOption->due_date = $serie['due-date'];
                $dbOption->days_to_maturity = $serie['days-to-maturity'];
                $dbOption->strike = $option['strike'];
                $dbOption->price = $option['close'];
                $dbOption->spot_price = $option['spot-price'];
                $dbOption->volume = $option['volume'];
                $dbOption->variation = $option['variation'];
                $dbOption->save();
            }
        }
    }
}
