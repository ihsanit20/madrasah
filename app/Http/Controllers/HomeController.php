<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\NoticeResource;
use App\Models\Classes;
use App\Models\HijriMonth;
use App\Models\Notice;
use App\Models\Setting;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Alkoumi\LaravelHijriDate\Hijri;

class HomeController extends Controller
{
    public function index()
    {
        $classes = Classes::get();

        $notices = Notice::query()
            ->whereDate('date', '<=', date('Y-m-d'))
            ->latest('date')
            ->take(10)
            ->get();

        $date = date("Y-m-d");

        $hijri_month_data = HijriMonth::find(Hijri::Date('m', $date));

        $calender = [
            'currentYear'   => Hijri::Date('Y', $date),
            'currentMonth'  => [
                'number' => (int) Hijri::Date('m', $date),
                'en'     => $hijri_month_data->english ?? '',
                'bn'     => $hijri_month_data->bengali ?? '',
                'ar'     => $hijri_month_data->arabic ?? '',
            ],
            'currentDay'    => Hijri::Date('d', $date),
            'days'          => $this->getMonthDays($date),
            'startFrom'     => $this->getStratFromOfWeekDay(Hijri::Date('w', $date), Hijri::Date('d', $date)),
        ];

        return Inertia::render('Home/Index', [
            'data' => [
                'classes' => $classes,
                'notices' => NoticeResource::collection($notices),
                'principalMessage' => $this->getSettingProperty('principal-message'),
                'headline' => $this->getSettingProperty('headline'),
                'ourMessage' => $this->getSettingProperty('our-message'),
                'calendar' => $calender,
            ]
        ]);
    }

    public function getMonthDays($date = null)
    {
        $date = $date ?? date("Y-m-d");

        $date_array = explode("-", $date);

        if(strlen($date_array[2]) == 4) {
            $date_array = array_reverse($date_array);
        }

        $date = implode("-", $date_array);

        $days = Array();

        for($i = 1; $i <= Hijri::Date('t', $date); $i++) {
            $days[] = $i;
        }

        return $days;
    }

    public function getStratFromOfWeekDay($current_weekday, $current_day)
    {
        if(!$current_weekday && !$current_day) {
            return 0;
        }
        
        $current_day = $current_day % 7;
        $startFrom = 0;

        switch($current_weekday) {
            case $current_weekday == 6:
                $startFrom = abs(1 - $current_day);
                break;

            case $current_weekday == 0:
                $startFrom = abs(2 - $current_day);
                break;

            case $current_weekday == 1:
                $startFrom = abs(3 - $current_day);
                break;

            case $current_weekday == 2:
                $startFrom = abs(4 - $current_day);
                break;

            case $current_weekday == 3:
                $startFrom = abs(5 - $current_day);
                break;

            case $current_weekday == 4:
                $startFrom = abs(6 - $current_day);
                break;

            case $current_weekday == 5:
                $startFrom = abs(7 - $current_day);
                break;
        }

        return $startFrom % 7;
    }

    public function notice(Notice $notice)
    {
        NoticeResource::withoutWrapping();
    
        return Inertia::render('Page/Notice', [
            'data' => [
                'notice' => new NoticeResource($notice),
            ]
        ]);
    }

    public function class(Classes $class)
    {
        ClassesResource::withoutWrapping();
    
        return Inertia::render('Page/Class', [
            'data' => [
                'classes'   => new ClassesResource(
                    $class->load(
                        'subjects',
                        'class_fees.fee',
                    )
                ),
                'packages'  => Student::getResidentArrayData(),
            ]
        ]);
    }

    public function admissionForm()
    {
        return Inertia::render('Page/AdmissionForm', [
            'data' => [
                //
            ]
        ]);
    }

    public function admissionFormBlank()
    {
        return Inertia::render('Page/AdmissionFormBlank', [
            'data' => [
                //
            ]
        ]);
    }
}
