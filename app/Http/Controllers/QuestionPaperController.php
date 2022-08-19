<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\ExamResource;
use App\Http\Resources\QuestionPaperResource;
use App\Http\Resources\SubjectResource;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionPaper;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionPaperController extends Controller
{
    public function exams()
    {
        $collections = Exam::query()
            ->latest();

        ExamResource::withoutWrapping();

        return Inertia::render('QuestionPaper/Exam', [
            'data' => [
                'exams' => ExamResource::collection($collections->get()),
            ]
        ]);
    }

    
    public function classes(Exam $exam)
    {
        ClassesResource::withoutWrapping();

        return Inertia::render('QuestionPaper/Class', [
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

        return Inertia::render('QuestionPaper/Subject', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'class'     => ClassesResource::make($class),
                'subjects'  => SubjectResource::collection($class->subjects()->get()),
            ]
        ]);
    }

    public function questionPaper(Exam $exam, Classes $class, $subject_code)
    {
        $class->load([
            'subjects:id,name,class_id'
        ]);

        $subject = $class->subjects->where('code', $subject_code)->first() ?? abort(404);

        $questionPaper = QuestionPaper::withTrashed()
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

        $questionPaper->load([
            'exam',
            'class',
            'questions'
        ]);

        QuestionPaperResource::withoutWrapping();
        SubjectResource::withoutWrapping();

        return Inertia::render('QuestionPaper/QuestionPaper', [
            'data' => [
                'questionPaper' => new QuestionPaperResource($questionPaper),
                'subject'       => new SubjectResource($subject),
                'languageList'  => QuestionPaper::getLanguageType(),
                'madrasahName'  => QuestionPaper::getMadrasahName(),
            ]
        ]);
    }

    public function questionPaperSave(Request $request, Exam $exam, Classes $class, $subject_code)
    {
        $questionPaper = QuestionPaper::query()
            ->where([
                'exam_id'       => $exam->id,
                'class_id'      => $class->id,
                'subject_code'  => $subject_code,
            ])->first();

        $questionPaper->update([
            'language_type' => $request->language_type,
            'mark'          => $request->mark,
            'top_text'      => $request->top_text,
            'time_in_minute'=> $request->hour * 60 + $request->minute,    
        ]);

        Question::where('question_paper_id', $questionPaper->id)->delete();

        if(is_array($request->questions)) {
            foreach($request->questions as $question) {
                Question::onlyTrashed()
                    ->updateOrCreate(
                        [],
                        [
                            'question_paper_id' => $questionPaper->id,
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