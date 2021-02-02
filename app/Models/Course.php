<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['name', 'place_name', 'coach_name', 'field_name', 'persian_status'];

    public function init()
    {
        // update course itself
        $this->open = 0;
        $this->started = 1;
        $this->save();

        // register sessions in db
        $date = now();
        $count = 0;
        $current_course_week_days = $this->schedules->pluck('persian_week_day_number')->toArray();
        while ($count != $this->sessions) {
            $week_day = persianWeekDay($date->dayOfWeek);
            if (in_array($week_day, $current_course_week_days)) {
                $schedule = Schedule::where('course_id', $this->id)->where('persian_week_day_number', $week_day)->first();
                CourseSession::create([
                    'course_id' => $this->id,
                    'date' => $date,
                    'from' => $schedule->from,
                    'till' => $schedule->till,
                ]);
                $count++;
            }
            $date->addDays(1);
        }

    }

    public function getNameAttribute()
    {
        $gender = $this->male ? "آقایان" : "بانوان";
        return "دوره {$this->field->name} در {$this->salon->name} - {$this->place->name} ($gender)";
    }

    public function getPlaceNameAttribute()
    {
        return $this->place ? $this->place->name : '-';
    }

    public function getCoachNameAttribute()
    {
        return $this->coach ? $this->coach->name : '-';
    }

    public function getFieldNameAttribute()
    {
        return $this->field ? $this->field->name : '-';
    }

    public function getPersianStatusAttribute()
    {
        if ($this->finished) {
            return 'خاتمه یافته';
        }
        if ($this->started) {
            return 'درحال برگزاری';
        }
        if ($this->open) {
            return 'درحال ثبت نام';
        }
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function getSchedules($number)
    {
        return Schedule::where('course_id', $this->id)->where('persian_week_day_number', $number)->get();
    }

}
