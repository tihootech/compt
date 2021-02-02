<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Schedule;

class CourseController extends Controller
{

    public function index($filter='all')
    {
        $courses = Course::query();

        if ($filter == 'open') {
            $courses = $courses->whereOpen(1);
        }

        return $courses->latest()->get();
    }

    public function init(Course $course)
    {
        $course->init();
        $days = ScheduleController::getCalendarDays();
        return ['success' => true, 'days' => $days];
    }

    public function upsert(Request $request, Course $course)
    {
        // validate incoming request
        $request->validate([
            'course.capacity' => 'required|integer',
            'course.sessions' => 'required|integer',
            'course.salon' => 'required|exists:salons,id',
            'course.place' => 'required|exists:places,id',
            'course.coach' => 'required|exists:coaches,id',
            'course.field' => 'required|exists:fields,id',
            'course.male' => 'required|boolean',
            'course.auto_start' => 'nullable|boolean',
        ]);

        // create schedules array and check for errors
        $schedules = [];
        $schedule_errors = [];
        foreach ($request->schedules as $persian_week_day_number => $schedule) {
            if ($schedule['from'] && $schedule['till']) {

                // check if coach is available
                $coach_courses = Course::where('coach_id', $request->course['coach'])->get();
                $coach_ok = self::checkCoursesForTimeInterface($coach_courses, $persian_week_day_number, $schedule);

                // check if place is available
                $place_courses = Course::where('place_id', $request->course['place'])->get();
                $place_ok = self::checkCoursesForTimeInterface($place_courses, $persian_week_day_number, $schedule);

                if (!$place_ok) {
                    $schedule_errors []= "دوره دیگری در این سالن در روز ".persianWeekDayName($persian_week_day_number)." در این بازه زمانی در حال برگزاری است";
                }
                if (!$coach_ok) {
                    $schedule_errors []= "این مربی در روز ".persianWeekDayName($persian_week_day_number)." در این بازه زمانی در دسترس نیست";
                }
                if ($place_ok && $coach_ok) {
                    $schedules []= [
                        'persian_week_day_number' => $persian_week_day_number,
                        'from' => $schedule['from'],
                        'till' => $schedule['till'],
                    ];
                }

            }
        }

        // check for schedule errors
        if (count($schedule_errors)) {
            return ['errors' => $schedule_errors];
        }

        // store course and schedules in db if any
        if (count($schedules)) {

            $course = Course::create([
                'code' => rand(100000, 999999),
                'capacity' => $request->course['capacity'],
                'sessions' => $request->course['sessions'],
                'salon_id' => $request->course['salon'],
                'place_id' => $request->course['place'],
                'coach_id' => $request->course['coach'],
                'field_id' => $request->course['field'],
                'auto_start' => $request->course['auto_start'] ?? 0,
                'male' => $request->course['male'],
            ]);

            foreach ($schedules as $schedule) {
                $schedule['course_id'] = $course->id;
                Schedule::create($schedule);
            }

        }else {
            return ['errors' => ['هیچ برنامه ای برای ذخیره وجود ندارد.']];
        }

        return ['success' => true];
    }

    private static function checkCoursesForTimeInterface($courses, $persian_week_day_number, $schedule)
    {
        $isOk = true;
        foreach ($courses as $c) {
            foreach ($c->getSchedules($persian_week_day_number) as $s) {
                $now = time();
                $startTime = strtotime( $s->from, $now );
                $endTime = strtotime( $s->till, $now );
                $point1 = strtotime($schedule['from'], $now);
                $point2 = strtotime($schedule['till'], $now);
                if( ($point1 > $startTime && $point1 < $endTime) || ($point2 > $startTime && $point2 < $endTime) ) {
                    $isOk = false;
                    break 2;
                }
            }
        }
        return $isOk;
    }
}
