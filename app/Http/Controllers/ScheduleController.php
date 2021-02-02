<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\CourseSession;

class ScheduleController extends Controller
{
    public function calendarSessions($week=0)
    {
        return self::getCalendarDays($week);
    }

    public static function getCalendarDays($week=0)
    {
        $date = now()->addDays($week*7);
        $days = [];
        for ($i=0; $i < 7 ; $i++) {
            $days[$date->toString()] = CourseSession::whereDate('date', $date)->with('course')->get();
            $date = $date->addDays(1);
        }
        return $days;
    }

}
