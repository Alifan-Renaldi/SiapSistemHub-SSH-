<?php
if (!function_exists('dateToString')) {
    function dateToString($date, $format = 'Y-m-d') {
        if (empty($date)) {
            return '-';
        }

        return date($format, strtotime($date));
    }
}
?>