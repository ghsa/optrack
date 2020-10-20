<?php

namespace App\Helpers;

class MoneyTransformHelper
{
    public static function moneyBRToUSA($valor)
    {
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);
        $valor = str_replace("R$", "", $valor);
        return $valor;
    }

    public static function moneyUSAToBR($valor)
    {
        return number_format($valor, 2, ",", ".");
    }
}
