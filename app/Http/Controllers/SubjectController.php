<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\SubjectResource;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SubjectController extends Controller
{
    public function index()
    {
        $collections = Subject::query();

        return Inertia::render('Subject/Index', [
            'data' => [
                'collections'   => SubjectResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        ClassesResource::withoutWrapping();

        $classes = Classes::get();

        return Inertia::render('Subject/Create', [
            'data' => [
                'subject'       => new Subject(),
                'classesList'   => ClassesResource::collection($classes),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $subject = Subject::create($this->validateData($request));

        return redirect()
            ->route('subjects.show', $subject->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Subject $subject)
    {
        SubjectResource::withoutWrapping();

        return Inertia::render('Subject/Show', [
            'data' => [
                'subject' => new SubjectResource($subject),
            ]
        ]);
    }

    public function edit(Subject $subject)
    {
        SubjectResource::withoutWrapping();
        ClassesResource::withoutWrapping();

        $classes = Classes::get();

        return Inertia::render('Subject/Edit', [
            'data' => [
                'subject'       => new SubjectResource($subject),
                'classesList'   => ClassesResource::collection($classes),
            ]
        ]);
    }

    public function update(Request $request, Subject $subject)
    {
        $subject->update($this->validateData($request, $subject->id));

        return redirect()
            ->route('subjects.show', $subject->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()
            ->route('subjects.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function getFilterProperty()
    {
        return [
            //
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique(Subject::class, 'name')
                    ->where('class_id', $request->class_id)
                    ->ignore($id),
            ],
            'class_id' => [
                'required',
                'numeric'
            ],
        ]);
    }

}