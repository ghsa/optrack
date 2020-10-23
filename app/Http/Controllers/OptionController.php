<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use LiliControl\LiliController;

class OptionController extends LiliController
{
    public function __construct(Stock $model)
    {
        $this->model = $model;
    }
}
