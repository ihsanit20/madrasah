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

        $today = date("d-m-Y");

        // $today = "01-01-2022"; //testing

        $response = Http::get("https://api.aladhan.com/v1/gToH?date={$today}");

        $response = $response->object();
        
        $current_weekday = $response->data->gregorian->weekday->en;

        $current_day = $response->data->hijri->day;

        $current_month = $response->data->hijri->month;

        $current_month->bn = HijriMonth::find($current_month->number)->bengali ?? $current_month->en;

        $current_year = $response->data->hijri->year;


        $response = Http::get("https://api.aladhan.com/v1/hToGCalendar/{$current_month->number}/{$current_year}");

        $response = $response->object();

        return Inertia::render('Home/Index', [
            'data' => [
                'classes' => $classes,
                'notices' => NoticeResource::collection($notices),
                'principalMessage' => $this->getSettingProperty('principal-message'),
                'headline' => $this->getSettingProperty('headline'),
                'ourMessage' => $this->getSettingProperty('our-message'),
                'calendar' => [
                    'currentYear'   => $current_year,
                    'currentMonth'  => $current_month,
                    'currentDay'    => $current_day,
                    'days'          => $response->data,
                    'startFrom'     => $this->getStratFromOfWeekDay($current_weekday, $current_day),
                ]
            ]
        ]);
    }

    public function getStratFromOfWeekDay($current_weekday, $current_day)
    {
        $current_day = $current_day % 7;
        $startFrom = 0;

        switch($current_weekday) {
            case $current_weekday == 'Saturday':
                $startFrom = abs(1 - $current_day);
                break;

            case $current_weekday == 'Sunday':
                $startFrom = abs(2 - $current_day);
                break;

            case $current_weekday == 'Monday':
                $startFrom = abs(3 - $current_day);
                break;

            case $current_weekday == 'Tuesday':
                $startFrom = abs(4 - $current_day);
                break;

            case $current_weekday == 'Wednesday':
                $startFrom = abs(5 - $current_day);
                break;

            case $current_weekday == 'Thursday':
                $startFrom = abs(6 - $current_day);
                break;

            case $current_weekday == 'Friday':
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
