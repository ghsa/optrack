<?php

namespace App\Repositories;

use App\Models\Option;

class StockRepositories
{

    public function getOptionsArray($stock_id)
    {
        return Option::where('stock_id', $stock_id)
            ->where('due_date', '>=', date('Y-m-d'))
            ->orderBy('due_date')
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id');
    }
}
