<?php

if (!function_exists('jenjangFromClass')) {
    function jenjangFromClass($c) {
        if (!$c) return '-';
        $num = intval($c);
        if ($num >= 1 && $num <= 6) return 'SD';
        if ($num >= 7 && $num <= 9) return 'SMP';
        if ($num >= 10) return 'SMK';
        return '-';
    }
}

if (!function_exists('getDayNameIndonesia')) {
    function getDayNameIndonesia($day) {
        $dayMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        return $dayMap[$day] ?? $day;
    }
}
