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

        $results = Result::query()
            ->where([
                'exam_id'   => $exam->id,
                'class_id'  => $class->id,
            ])
            ->get();

        $students = $admissions->map(function ($admission) use ($results) {
            return [
                "id"    => $admission->student->id,
                "name"  => $admission->student->name,
                "roll"  => $admission->roll,
                "marks" => $results->where('student_id', $admission->student->id)->first()->marks ?? [],
            ];
        });

        return Inertia::render('Result/Subject', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'class'     => ClassesResource::make($class),
                'subjects'  => SubjectResource::collection($class->subjects()->get()),
                'students'  => $students,
            ]
        ]);
    }

    public function result(Exam $exam, Classes $class, $subject_code)
    {
        $class->load([
            'subjects:id,class_id,name,book'
        ]);

        $subject = $class->subjects->where('code', $subject_code)->first() ?? abort(404);

        $result = Result::withTrashed()
            ->updateOrCreate(
                [
                    'exam_id'       => $exam->id,
                    'class_id'      => $class->id,
                    'subject_code'  => $subject_code,
                ], 
                [
                    'deleted_at'    => null,
                ]
            );

        $result->load([
            'exam',
            'class',
            'questions'
        ]);

        ResultResource::withoutWrapping();
        SubjectResource::withoutWrapping();

        return Inertia::render('Result/Result', [
            'data' => [
                'result' => new ResultResource($result),
                'subject'       => new SubjectResource($subject),
                'languageList'  => Result::getLanguageType(),
                'madrasahName'  => Result::getMadrasahName(),
            ]
        ]);
    }

    public function resultSave(Request $request, Exam $exam, Classes $class, $subject_code)
    {
        $result = Result::query()
            ->where([
                'exam_id'       => $exam->id,
                'class_id'      => $class->id,
                'subject_code'  => $subject_code,
            ])->first();

        $result->update([
            'language_type' => $request->language_type,
            'mark'          => $request->mark,
            'book_name'     => $request->book_name,
            'top_text'      => $request->top_text,
            'bottom_text'   => $request->bottom_text,
            'time_in_minute'=> $request->hour * 60 + $request->minute,    
        ]);

        Question::where('question_paper_id', $result->id)->delete();

        if(is_array($request->questions)) {
            foreach($request->questions as $question) {
                Question::onlyTrashed()
                    ->updateOrCreate(
                        [],
                        [
                            'question_paper_id' => $result->id,
                            'title'             => $question["title"],
                            'body'              => $question["body"],
                            'mark'              => $question["mark"],
                            'deleted_at'        => null,
                        ]
                    );
            }
        }

        return redirect()->route('question-papers.question-paper', [ $exam->id, $class->id, $subject_code]);
    }
}
