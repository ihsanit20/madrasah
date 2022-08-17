<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\ExamResource;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\ExamClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExamController extends Controller
{
    public function index()
    {
        $collections = Exam::query();

        return Inertia::render('Exam/Index', [
            'data' => [
                'collections'   => ExamResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Exam/Create', [
            'data' => $this->data(new Exam())
        ]);
    }

    public function store(Request $request)
    {
        $exam = Exam::create($this->validatedData($request));

        $this->storeExamClass($exam, $request->get('classes'));

        return redirect()
            ->route('exams.show', $exam->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Exam $exam)
    {
        $exam->load('classes:id,name');

        return Inertia::render('Exam/Show', [
            'data' => [
                'exam' => $this->formatedData($exam)
            ]
        ]);
    }

    public function edit(Exam $exam)
    {
        return Inertia::render('Exam/Edit', [
            'data' => $this->data($exam)
        ]);
    }

    public function update(Request $request, Exam $exam)
    {
        $exam->update($this->validatedData($request, $exam->id));

        $this->storeExamClass($exam, $request->get('classes'));

        return redirect()
            ->route('exams.show', $exam->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()
            ->route('exams.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($exam)
    {
        ClassesResource::withoutWrapping();

        $classes = Classes::query()
            // ->with('subjects:id,class_id,name')
            ->get(['id', 'name']);

        $exam->load('classes:id,name');

        return [
            'exam'      => $this->formatedData($exam),
            'classes'   => ClassesResource::collection($classes),
        ];
    }

    protected function formatedData($exam)
    {
        ExamResource::withoutWrapping();

        return new ExamResource($exam);
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
            'name'        => 'required|string',
            'session'     => 'required|string',
        ]);
    }

    protected function storeExamClass($exam, $classes)
    {
        ExamClass::where('exam_id', $exam->id)->delete();

        if (!empty($classes)) {
            foreach ($classes as $class) {
                ExamClass::onlyTrashed()->updateOrCreate(
                    [], 
                    [
                        'exam_id'       => $exam->id,
                        'class_id'      => $class,
                        'deleted_at'    => null,
                    ]
                );
            }
        }
    }

}