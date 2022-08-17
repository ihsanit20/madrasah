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

        return Inertia::render('AdmitCard/Show', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'classes'   => ClassesResource::collection($exam->classes()->with('students')->get()),
            ]
        ]);
    }

    public function list(Exam $exam, Classes $class)
    {
        $principal = Staff::query()
            ->with('signature')
            ->where('designation_id', 1)
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';

        StudentResource::withoutWrapping();
        ClassesResource::withoutWrapping();
        ExamResource::withoutWrapping();

        return Inertia::render('AdmitCard/List', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'class'     => new ClassesResource($class),
                'students'  => StudentResource::collection($class->students()->with('current_admission')->get()),
                'signature' => $signature,
            ]
        ]);
    }
}
