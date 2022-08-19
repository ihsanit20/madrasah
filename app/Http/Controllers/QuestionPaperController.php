<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\ExamResource;
use App\Http\Resources\QuestionPaperResource;
use App\Http\Resources\SubjectResource;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\QuestionPaper;
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
                'classes'   => ClassesResource::collection($exam->classes()->with('students')->get()),
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

    public function index()
    {
        $collections = Exam::query()
            ->latest();

        ExamResource::withoutWrapping();

        return Inertia::render('QuestionPaper/Index', [
            'data' => [
                'exams' => ExamResource::collection($collections->get()),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('QuestionPaper/Create', [
            'data' => $this->data(new QuestionPaper())
        ]);
    }

    public function store(Request $request)
    {
        $questionPaper = QuestionPaper::create($this->validatedData($request));

        return redirect()
            ->route('question-papers.show', $questionPaper->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Exam $exam)
    {
        ClassesResource::withoutWrapping();

        $exam->load('seat_plans');

        return Inertia::render('QuestionPaper/Show', [
            'data' => [
                'exam'      => new ExamResource($exam),
                'classes'   => ClassesResource::collection($exam->classes()->with('students')->get()),
            ]
        ]);
    }

    public function edit(QuestionPaper $questionPaper)
    {
        return Inertia::render('QuestionPaper/Edit', [
            'data' => $this->data($questionPaper)
        ]);
    }

    public function update(Request $request, QuestionPaper $questionPaper)
    {
        $questionPaper->update($this->validatedData($request, $questionPaper->id));

        return redirect()
            ->route('question-papers.show', $questionPaper->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(QuestionPaper $questionPaper)
    {
        $questionPaper->delete();

        return redirect()
            ->route('question-papers.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($questionPaper)
    {
        return [
            'questionPaper' => $this->formatedData($questionPaper),
        ];
    }

    protected function formatedData($questionPaper)
    {
        QuestionPaperResource::withoutWrapping();

        return new QuestionPaperResource($questionPaper);
    }

    protected function getFilterProperty()
    {
        return [
            //
        ];
    }

    protected function validatedData($request, $id = '')
    {
        return $request->validate([
            //
        ]);
    }

}