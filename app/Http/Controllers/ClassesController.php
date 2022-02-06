<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassesResource;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ClassesController extends Controller
{
    public function index()
    {
        $collections = Classes::query()
            ->filter()
            ->latest();

        return Inertia::render('Classes/Index', [
            'data' => [
                'collections'   => ClassesResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Classes/Create', [
            'data' => [
                'classes' => new Classes(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $class = Classes::create($this->validateData($request));

        return redirect()
            ->route('classes.show', $class->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Classes $class)
    {
        ClassesResource::withoutWrapping();

        return Inertia::render('Classes/Show', [
            'data' => [
                'classes' => new ClassesResource($class),
            ]
        ]);
    }

    public function edit(Classes $class)
    {
        ClassesResource::withoutWrapping();

        return Inertia::render('Classes/Edit', [
            'data' => [
                'classes' => new ClassesResource($class),
            ]
        ]);
    }

    public function update(Request $request, Classes $class)
    {
        $class->update($this->validateData($request, $class->id));

        return redirect()
            ->route('classes.show', $class->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Classes $class)
    {
        $class->delete();

        return redirect()
            ->route('classes.index')
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
                Rule::unique(Classes::class, 'name')->ignore($id),
            ]
        ]);
    }

}