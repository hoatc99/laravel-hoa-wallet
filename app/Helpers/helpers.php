<?php

if (! function_exists('formatNumber')) {
    function formatNumber($number)
    {
        $number /= 1000;

        return number_format(round($number, 1)).'K';
    }
}
