<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Stock;

class OpSimulatorController extends Controller
{
    public function simulator($id)
    {
        $option = Option::find($id);

        return view('dashboard.option.simulator', compact('option'));
    }
}
