<?php

function persianToCarbon($pdate, $format = 'Y/m/d')
{
    return \Morilog\Jalali\Jalalian::fromFormat($format, $pdate)->toCarbon();
}

function persianWeekDay($enWeekDay)
{
    return $enWeekDay == 6 ? 0 : ($enWeekDay == 7 ? 1 : $enWeekDay+1);
}

function persianWeekDayName($number)
{
    $days = [
        'شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه'
    ];
    return isset($days[$number]) ? $days[$number] : '';
}
