<?php

if (!function_exists('price')) {
    function price($value)
    {
        return number_format($value, 2, ',', '.');
    }
}
