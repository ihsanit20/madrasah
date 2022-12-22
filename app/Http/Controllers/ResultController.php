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
use App\Models\Staff;
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
            ->orderBy('roll')
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

        $principal = Staff::query()
            ->with('signature')
            ->where('designation_id', 1)
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';

        return Inertia::render('Result/Subject', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'class'     => ClassesResource::make($class),
                'subjects'  => SubjectResource::collection($class->subjects()->get()),
                'students'  => $students,
                'results'   => $results,
            ],
            'signature' => $signature,
        ]);
    }

    public function resultCard(Exam $exam, Classes $class)
    {
        // return
        $admissions = Admission::query()
            ->with([
                'student:id,name,registration',
            ])
            ->student()
            ->current()
            ->where([
                'class_id' => $class->id,
            ])
            ->orderBy('roll')
            ->get([
                'id',
                'class_id',
                'student_id',
                'roll',
            ]);

        // return
        $subjectwise_results = Result::query()
            ->where([
                'exam_id'   => $exam->id,
                'class_id'  => $class->id,
            ])
            ->get();
            
        $studentwise_results = [];

        foreach($subjectwise_results as $result) {

            foreach($result->marks as $mark) {
                $studentwise_results[$mark["student_id"]][$result->subject_code] = [
                    'writing'       => $mark["writing"],
                    'speaking'      => $mark["speaking"],
                ];
            }

        }

        // return $studentwise_results;   

        $students = $admissions->map(function ($admission) use ($studentwise_results) {

            return [
                "id"            => $admission->student_id,
                "name"          => $admission->student->name,
                "roll"          => $admission->roll,
                "results"       => $studentwise_results[$admission->student_id],
                "registration"  => $admission->student->registration,
            ];
        });

        // return $students;

        $principal = Staff::query()
            ->with('signature')
            ->where('designation_id', 1)
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';
        
        ClassesResource::withoutWrapping();
        SubjectResource::withoutWrapping();
        ResultResource::withoutWrapping();

        return Inertia::render('Result/ResultCard', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'class'     => ClassesResource::make($class),
                'subjects'  => SubjectResource::collection($class->subjects()->get()),
                'students'  => $students,
                'results'   => $subjectwise_results,
            ],
            'signature' => $signature,
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

        // return
        $admissions = Admission::query()
            ->with([
                'student:id,name',
            ])
            ->student()
            ->current()
            ->orderBy('roll')
            ->where([
                'class_id' => $class->id,
            ])
            ->get([
                'id',
                'class_id',
                'student_id',
                'roll',
            ]);

        $class_student_ids = [];
        $result_student_ids = [];

        // return
        $students = $admissions->map(function ($admission) use (&$class_student_ids) {
            array_push($class_student_ids, $admission->student->id);

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

        // return $marks;

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

        foreach($result->marks as $mark) {
            array_push($result_student_ids, $mark["student_id"]);
        }

        // return compact('class_student_ids', 'result_student_ids');

        // return
        $diff_ids = array_diff($class_student_ids, $result_student_ids);

        if(count($diff_ids)) {
            // return
            $result_marks = $result->marks;

            foreach($diff_ids as $diff_id) {
                array_push($result_marks, [
                    'student_id'    => $diff_id,
                    'writing'       => "",
                    'speaking'      => "",
                ]);
            }

            $result->update(['marks' => $result_marks]);
        }

        // return $result;
        
        $result->subject = $subject;

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
            $exam->id,
            $class->id
        ]);
    }
}
