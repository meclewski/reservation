<?php
namespace App\Service;

class DateArray
{

    public function getDatesFromRange($start, $end, $format='Y-m-d') {
        return array_map(function($timestamp) use($format) {
            return date($format, $timestamp);
        },
        range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
    }
}