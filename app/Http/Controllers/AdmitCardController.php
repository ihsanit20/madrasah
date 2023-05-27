<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\ExamResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Staff;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdmitCardController extends Controller
{
    public function index()
    {
        $collections = Exam::query()
            ->current()
            ->latest();

        ExamResource::withoutWrapping();

        return Inertia::render('AdmitCard/Index', [
            'data' => [
                'exams' => ExamResource::collection($collections->get()),
            ]
        ]);
    }

    public function show(Exam $exam)
    {
        ClassesResource::withoutWrapping();

        $exam->load('seat_plans');

        $seat_plans = $exam->seat_plans()
            ->pluck('classes');

        $seat_plan_classes = Array();

        foreach($seat_plans as $seat_plan) {
            foreach($seat_plan as $class) {
                $seat_plan_classes[] = $class;
            }
        }

        return Inertia::render('AdmitCard/Show', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'classes'   => ClassesResource::collection($exam->classes()->with('students')->get()),
                'seat_plan_classes' => $seat_plan_classes,
            ]
        ]);
    }

    public function list(Exam $exam, Classes $class)
    {
        $principal = Staff::query()
            ->with('signature')
            ->principal()
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';

        $class->load('subjects');

        StudentResource::withoutWrapping();
        ClassesResource::withoutWrapping();
        ExamResource::withoutWrapping();

        $students = $class->students()
            ->with([
                'current_admission',
                'guardian_info',
            ])
            ->get();

        $exam->load('seat_plans');

        $seat_plans = $exam->seat_plans()
            ->pluck('seats');

        foreach($seat_plans as $seat_plan) {
            foreach($seat_plan as $index => $seat) {
                $student = $students->where('id', $seat)->first();
                
                if($student) {
                    $student->seat_no = $index + 1;
                }
            }
        }

        return Inertia::render('AdmitCard/List', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'class'     => new ClassesResource($class),
                'students'  => StudentResource::collection($students),
                'signature' => $signature,
            ]
        ]);
    }
}
