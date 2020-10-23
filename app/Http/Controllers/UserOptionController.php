<?php

namespace App\Http\Controllers;

use App\Helpers\MoneyTransformHelper;
use App\Models\Option;
use App\Models\UserOption;
use Illuminate\Support\Facades\Auth;
use LiliControl\LiliController;

class UserOptionController extends LiliController
{
    public $paginate = 1000;

    public function create()
    {
        $optionId = request()->option_id;
        $option = Option::find($optionId);
        $model = $this->model;
        $userStock = $option->stock->getUserStock(Auth::user());
        return view($this->model->getBaseRouteName() . '.create', compact('model', 'optionId', 'option', 'userStock'));
    }

    public function show($id)
    {
        $model = $this->model->find($id);
        $option = $model->option;
        return view($this->model->getBaseRouteName() . '.show', compact('model', 'option'));
    }

    public function __construct(UserOption $model)
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
        $data['sell_price'] = !empty($data['sell_price']) ? MoneyTransformHelper::moneyBRToUSA($data['sell_price']) : 0;
        $data['buy_price'] = !empty($data['buy_price'])
            ? MoneyTransformHelper::moneyBRToUSA($data['buy_price']) : 0;
        return $data;
    }
}
