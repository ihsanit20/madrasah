<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function index()
    {
        $collections = Department::query();

        return Inertia::render('Department/Index', [
            'data' => [
                'collections'   => DepartmentResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Department/Create', [
            'data' => $this->data(new Department())
        ]);
    }

    public function store(Request $request)
    {
        // return $request;

        $department = Department::create($this->validatedData($request));

        return redirect()
            ->route('departments.show', $department->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Department $department)
    {
        $department->load('academic_sessions');

        // return $this->formatedData($department);

        return Inertia::render('Department/Show', [
            'data' => [
                'department' => $this->formatedData($department)
            ]
        ]);
    }

    public function edit(Department $department)
    {
        return $this->data($department);

        return Inertia::render('Department/Edit', [
            'data' => $this->data($department)
        ]);
    }

    public function update(Request $request, Department $department)
    {
        $department->update($this->validatedData($request, $department->id));

        return redirect()
            ->route('departments.show', $department->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($department)
    {
        return [
            'department' => $this->formatedData($department),
        ];
    }

    protected function formatedData($department)
    {
        DepartmentResource::withoutWrapping();

        return new DepartmentResource($department);
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
            'name' => [
                'required',
                'string',
                Rule::unique(Department::class, 'name')->ignore($id)
            ],
            'description' => [
                'nullable',
                'string',
            ]
        ]);
    }

}