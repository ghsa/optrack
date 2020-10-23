<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use LiliControl\LiliController;

class StockController extends LiliController
{
    public function __construct(Stock $model)
    {
        $this->model = $model;
    }

    protected function saveModelFromRequest()
    {
        $data = request()->all();

        $this->model->fill($data);
        $this->handleFilesToUpload();
        $this->model->save();
    }
}
