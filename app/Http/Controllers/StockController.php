<?php

namespace App\Http\Controllers;

use App\Helpers\MoneyTransformHelper;
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
        $data = $this->transformFields($data);

        $this->model->fill($data);
        $this->handleFilesToUpload();
        $this->model->save();
    }

    private function transformFields($data)
    {
        $data['user_id'] = \Auth::user()->id;
        $data['buy_price'] = !empty($data['buy_price']) ? MoneyTransformHelper::moneyBRToUSA($data['buy_price']) : 0;
        $data['fundamentalist_price'] = !empty($data['fundamentalist_price'])
            ? MoneyTransformHelper::moneyBRToUSA($data['fundamentalist_price']) : 0;
        return $data;
    }
}
