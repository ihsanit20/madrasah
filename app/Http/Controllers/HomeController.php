<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\NoticeResource;
use App\Models\Classes;
use App\Models\HijriMonth;
use App\Models\Notice;
use App\Models\Student;
use Inertia\Inertia;
use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Resources\AdmissionResource;
use App\Http\Resources\AreaResource;
use App\Http\Resources\ClassFeeResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\SimpleNoticeResource;
use App\Http\Resources\StudentResource;
use App\Models\Admission;
use App\Models\Area;
use App\Models\ClassFee;
use App\Models\District;
use App\Models\Division;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $classes = Classes::get();

        // return
        $notices = Notice::query()
            ->select([
                'id',
                'date',
                'title',
                'staff_id',
            ])
            ->with('staff')
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

        // return SimpleNoticeResource::collection($notices);

        PostResource::withoutWrapping();

        $settings = Setting::query()
            ->properties([
                'principal-message',
                'headline',
                'our-message'
            ])
            ->get();

        return Inertia::render('Home/Index', [
            'data' => [
                'classes' => $classes,
                'notices' => SimpleNoticeResource::collection($notices),
                'principalMessage' => $this->getSettingProperty('principal-message', $settings),
                'headline' => $this->getSettingProperty('headline', $settings),
                'ourMessage' => $this->getSettingProperty('our-message', $settings),
                'calendar' => $calender,
                "posts" => PostResource::collection(Post::inRandomOrder()->take(3)->get()),
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

    public function admission()
    {
        // return
        $admissions = Admission::query()
            ->with([
                'student:id,name,registration',
            ])
            ->where('session', "44-45")
            ->student()
            ->get([
                // '*'
                'id',
                'student_id',
                'class_id',
                'session',
                'status',
                'roll',
            ]);

        $classes = Classes::query()
            ->get([
                'id',
                'name',
            ]);

        return Inertia::render('Home/Admission', [
            'data' => [
                'admissions'    => $admissions,
                'classes'       => $classes,
            ],
        ]);
    }

    public function admissionForm()
    {
        $student = Student::find((int) (request()->student ?? 0));
        
        $type = request()->type === 'old' ? 'old' : 'new';
        
        if($student && $type == 'old') {
            // return
            $admission = Admission::query()
                ->with('class')
                ->where('session', "44-45")
                ->student()
                ->where('student_id', $student->id)
                ->first();

            if($admission) {
                // return
                $setting = Setting::where('key', 'site-name')->first();

                $school_name = $setting
                    ? ($setting->value ?? $setting->dummy) 
                    : '';

                $previous_school_info = [
                    "previous_school" => $school_name ?? "",
                    "previous_class" => $admission->class->name ?? "",
                    "previous_roll" => $admission->roll ?? "",
                    "previous_result" => "",
                ];
            }
        }

        return Inertia::render('Page/AdmissionForm', [
            'data' => $this->data(new Admission(), $student, $previous_school_info ?? null),
            'type' => $type,
            'old_student_id' => (int) (0),
        ]);
    }

    public function admissionFormSubmit(Request $request)
    {
        return $request;
    }

    public function admissionFormBlank()
    {
        return Inertia::render('Page/AdmissionFormBlank', [
            'data' => [
                //
            ]
        ]);
    }

    protected function data($admission, $student = null, $previous_school_info = null)
    {
        if(!$student) {
            $student = $admission->student()->first() ?? null;
        }

        $has_student = (boolean) ($student ?? false);

        if(!$has_student) {
            $student = new Student();
        }
        
        if($previous_school_info) {
            $admission->previous_school = $previous_school_info['previous_school'] ?? '';
            $admission->previous_class = $previous_school_info['previous_class'] ?? '';
            $admission->previous_roll = $previous_school_info['previous_roll'] ?? '';
            $admission->previous_result = $previous_school_info['previous_result'] ?? '';
        }

        return [
            'admission'     => $this->formatedData($admission),
            'student'       => $this->formatedStudentData($student),
            'divisions'     => DivisionResource::collection(Division::orderBy('name')->get()),
            'districts'     => DistrictResource::collection(District::orderBy('name')->get()),
            'areas'         => AreaResource::collection(Area::orderBy('name')->get()),
            'classes'       => ClassesResource::collection(Classes::get()),
            'bloodGroups'   => Student::getBloodGroups(),
            'residentArray' => Student::getResidentArrayData(),
            'yearlyFees'    => $this->getClassFee($admission->class_id, 1, $student->resident),
            'monthlyFees'   => $this->getClassFee($admission->class_id, 2, $student->resident),
            'hasStudent'    => (boolean) ($has_student ?? false),
        ];
    }

    protected function formatedData($admission)
    {
        AdmissionResource::withoutWrapping();

        return new AdmissionResource($admission);
    }

    protected function formatedStudentData($student)
    {
        StudentResource::withoutWrapping();

        return new StudentResource(
            $student->load([
                'father_info',
                'mother_info',
                'guardian_info',
                'present_address.area.district',
                'permanent_address.area.district',
            ]
        ));
    }

    protected function getClassFee($class_id, $period = null, $resident = null)
    {
        ClassFeeResource::withoutWrapping();

        $query = ClassFee::query()
            ->where('class_id', $class_id)
            ->where(function ($query) use ($period) {
                $query->when($period, function ($query) use ($period) {
                    $query->whereHas('fee', function ($query) use ($period) {
                        $query->where('period', $period);
                    });
                });
            });
        
        $class_fees = $query->get();

        if($resident) {
            $class_fees = $class_fees->filter(function ($class_fee) use ($resident) {
                return in_array($resident, json_decode($class_fee->package));
            });
        }

        return ClassFeeResource::collection($class_fees);
    }
}
