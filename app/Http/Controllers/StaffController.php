<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DesignationResource;
use App\Http\Resources\StaffResource;
use App\Models\Designation;
use App\Models\Staff;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
    public function list()
    {
        $collections = Staff::query();

        return Inertia::render('Staff/List', [
            'data' => [
                'collections'   => StaffResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function index()
    {
        $collections = Staff::query()
            ->orderBy('designation_id');

        StaffResource::withoutWrapping();

        return Inertia::render('Staff/Index', [
            'data' => [
                'staff'     => StaffResource::collection($collections->get()),
                'filters'   => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Staff/Create', [
            'data' => $this->data(new Staff())
        ]);
    }

    public function store(Request $request)
    {
        $staff = Staff::create($this->validatedData($request));

        return redirect()
            ->route('staff.show', $staff->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Staff $staff)
    {
        return Inertia::render('Staff/Show', [
            'data' => [
                'staff' => $this->formatedData($staff)
            ]
        ]);
    }

    public function edit(Staff $staff)
    {
        if(request()->step == 'salary') {
            return Inertia::render('Staff/Edit', [
                'data'  => $this->data($staff),
                'step'  => 'salary',
            ]);
        }

        return Inertia::render('Staff/Edit', [
            'data' => $this->data($staff)
        ]);
    }

    public function update(Request $request, Staff $staff)
    {
        if($request->step == 'salary') {
            $staff->update([
                "salaries" => $request->salaries,
            ]);
        } else {
            $staff->update($this->validatedData($request, $staff->id));
        }

        return redirect()
            ->route('staff.show', $staff->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()
            ->route('staff.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($staff)
    {
        DesignationResource::withoutWrapping();

        return [
            'staff' => $this->formatedData($staff),
            'designations' => DesignationResource::collection(Designation::get()),
        ];
    }

    protected function formatedData($staff)
    {
        StaffResource::withoutWrapping();

        return new StaffResource($staff);
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
            ],
            'designation_id' => [
                'required',
                'numeric',
            ],
            'phone' => '',
        ]);
    }

}