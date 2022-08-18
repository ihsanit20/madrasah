<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\ExamResource;
use App\Models\Admission;
use App\Models\Exam;
use App\Models\SeatPlan;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SeatPlanController extends Controller
{
    public function index()
    {
        $collections = Exam::query()
            ->latest();

        ExamResource::withoutWrapping();

        return Inertia::render('SeatPlan/Index', [
            'data' => [
                'exams' => ExamResource::collection($collections->get()),
            ]
        ]);
    }

    public function show(Exam $exam)
    {
        $class_ids = $exam->classes()
            ->pluck('class_id')
            ->toArray();

        $admissions = Admission::query()
            ->with('student:id,name,registration')
            ->student()
            ->whereIn('class_id', $class_ids)
            ->where('session', $this->getCurrentSession())
            ->get([
                'student_id',
                'class_id',
                'roll'
            ]);

        $seat_plans = $exam->seat_plans()
            ->pluck('seats');

        $serials = Array();

        foreach($seat_plans as $seat_plan) {
            foreach($seat_plan as $seat) {
                $admission = $admissions->where('student_id', $seat)->first();
                $serials[] = [
                    'student_name' => $admission->student->name ?? '',
                    'class_name' => $admission->class->name ?? '',
                    'class_roll' => $admission->roll ?? '',
                    'registration' => $admission->student->registration ?? '',
                ];
            }
        }

        return Inertia::render('SeatPlan/Show', [
            'data' => [
                'serials' => $serials,
            ]
        ]);
    }

    public function store(Exam $exam, Request $request)
    {
        $class_ids = $exam->classes()
            ->whereIn('class_id', $request->class_ids)
            ->pluck('class_id')
            ->toArray();

        $admissions = Admission::query()
            ->with('student:id,name,registration')
            ->student()
            ->whereIn('class_id', $class_ids)
            ->where('session', $this->getCurrentSession())
            ->get([
                'student_id',
                'class_id',
                'roll'
            ]);

        $students = Array();

        $admissions->map(function ($admission) use (&$students) {
            $students[$admission->class_id][] = $admission->student_id;
        });

        $students = array_map(function ($students) {
            shuffle($students);
            return $students;
        }, $students);
        
        $seats = Array();

        $max_class_id = $this->getMaxClassId($students);

        while($max_class_id) {
            $seats[] = array_pop($students[$max_class_id]) ?? null;
            $max_class_id = $this->getMaxClassId($students, $max_class_id);
        }

        SeatPlan::onlyTrashed()->updateOrCreate(
            [] ,
            [
                'exam_id'       => $exam->id,
                'classes'       => $request->class_ids,
                'seats'         => $seats,
                'deleted_at'    => null,
            ]
        );

        return redirect()
            ->route('seat-plan.show', $exam->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function getMaxClassId($students, $ignore_class_id = null)
    {
        $array = $students;

        if($ignore_class_id) {
            unset($array[$ignore_class_id]);
        }

        $count_array = array_map('count', $array);

        $max_class_id = array_keys($count_array, max($count_array))[0];

        if(count($students[$max_class_id])) {
            return $max_class_id;
        }

        if(count($students[$ignore_class_id])) {
            return $ignore_class_id;
        }
        
        return 0;
    }
}
