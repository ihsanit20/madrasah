<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\ExamResource;
use App\Http\Resources\ResultResource;
use App\Http\Resources\SubjectResource;
use App\Models\Admission;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Result;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResultController extends Controller
{
    
    public function exams()
    {
        $collections = Exam::query()
            ->latest();

        ExamResource::withoutWrapping();

        return Inertia::render('Result/Exam', [
            'data' => [
                'exams' => ExamResource::collection($collections->get()),
            ]
        ]);
    }

    public function classes(Exam $exam)
    {
        ClassesResource::withoutWrapping();

        return Inertia::render('Result/Class', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'classes'   => ClassesResource::collection($exam->classes()->with('subjects')->get()),
            ]
        ]);
    }

    
    public function subjects(Exam $exam, Classes $class)
    {
        ClassesResource::withoutWrapping();
        SubjectResource::withoutWrapping();
        ResultResource::withoutWrapping();

        $admissions = Admission::query()
            ->with([
                'student:id,name',
            ])
            ->student()
            ->current()
            ->where([
                'class_id' => $class->id,
            ])
            ->get([
                'id',
                'class_id',
                'student_id',
                'roll',
            ]);

        // return
        $results = Result::query()
            ->where([
                'exam_id'   => $exam->id,
                'class_id'  => $class->id,
            ])
            ->get();

        $students = $admissions->map(function ($admission) {
            return [
                "id"    => $admission->student->id,
                "name"  => $admission->student->name,
                "roll"  => $admission->roll,
            ];
        });

        // return $students;

        return Inertia::render('Result/Subject', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'class'     => ClassesResource::make($class),
                'subjects'  => SubjectResource::collection($class->subjects()->get()),
                'students'  => $students,
                'results'   => $results,
            ]
        ]);
    }

    public function create(Exam $exam, Classes $class, $subject_code)
    {
        $class->load([
            'subjects:id,class_id,name,book',
        ]);

        $subject = $class->subjects
            ->where('code', $subject_code)
            ->first() ?? abort(404);

        $admissions = Admission::query()
            ->with([
                'student:id,name',
            ])
            ->student()
            ->current()
            ->where([
                'class_id' => $class->id,
            ])
            ->get([
                'id',
                'class_id',
                'student_id',
                'roll',
            ]);

        $students = $admissions->map(function ($admission) {
            return [
                "id"    => $admission->student->id,
                "name"  => $admission->student->name,
                "roll"  => $admission->roll,
            ];
        });

        $marks = [];

        foreach($students as $student) {
            $marks[] = [
                'student_id'    => $student['id'],
                'writing'       => "",
                'speaking'      => "",
            ];
        }

        $result = Result::query()
            ->firstOrCreate(
                [
                    'exam_id'       => $exam->id,
                    'class_id'      => $class->id,
                    'subject_code'  => $subject->code,
                ],
                [
                    'marks'         => $marks,
                ]
            );

        $result->load([
            'exam:id,name,session',
            'class:id,name',
        ]);

        $result->subject = $subject;

        // return $result;

        ResultResource::withoutWrapping();

        // return ResultResource::make($result);

        return Inertia::render('Result/Create', [
            'data' => [
                'result'    => ResultResource::make($result),
                'students'  => $students,
            ]
        ]);
    }

    public function store(Request $request, Exam $exam, Classes $class, $subject_code)
    {
        $result = Result::query()
            ->where([
                'exam_id'       => $exam->id,
                'class_id'      => $class->id,
                'subject_code'  => $subject_code,
            ])->firstOrFail();

        $result->update([
            'marks' => $request->result["marks"],
        ]);

        return redirect()->route('results.subjects', [
            $exam->id, $class->id, $subject_code
        ]);
    }
}
