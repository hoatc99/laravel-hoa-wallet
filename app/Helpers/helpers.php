<?php

if (! function_exists('formatNumber')) {
    function formatNumber($number)
    {
        $suffixes = ["", "K", "M", "B", "T"];
        $suffixIndex = 0;

        while ($number >= 1000) {
            $number /= 1000;
            $suffixIndex++;
        }

        return round($number, 1) . $suffixes[$suffixIndex];
    }
}
