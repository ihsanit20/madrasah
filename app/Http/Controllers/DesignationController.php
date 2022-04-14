<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DesignationResource;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DesignationController extends Controller
{
    public function index()
    {
        $collections = Designation::query();

        return Inertia::render('Designation/Index', [
            'data' => [
                'collections'   => DesignationResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Designation/Create', [
            'data' => $this->data(new Designation())
        ]);
    }

    public function store(Request $request)
    {
        $designation = Designation::create($this->validatedData($request));

        return redirect()
            ->route('designations.index')
            ->with('status', 'The record has been added successfully.');

        return redirect()
            ->route('designations.show', $designation->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Designation $designation)
    {
        return Inertia::render('Designation/Show', [
            'data' => [
                'designation' => $this->formatedData($designation)
            ]
        ]);
    }

    public function edit(Designation $designation)
    {
        return Inertia::render('Designation/Edit', [
            'data' => $this->data($designation)
        ]);
    }

    public function update(Request $request, Designation $designation)
    {
        $designation->update($this->validatedData($request, $designation->id));

        return redirect()
            ->route('designations.index')
            ->with('status', 'The record has been update successfully.');

        return redirect()
            ->route('designations.show', $designation->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();

        return redirect()
            ->route('designations.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($designation)
    {
        return [
            'designation' => $this->formatedData($designation),
        ];
    }

    protected function formatedData($designation)
    {
        DesignationResource::withoutWrapping();

        return new DesignationResource($designation);
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
                Rule::unique(Designation::class, 'name')->ignore($id),
            ],
        ]);
    }

}