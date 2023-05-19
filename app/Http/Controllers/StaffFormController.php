<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;
use App\Http\Resources\DesignationResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\StaffFormResource;
use App\Models\Address;
use App\Models\Appointment;
use App\Models\Area;
use App\Models\Designation;
use App\Models\District;
use App\Models\Division;
use App\Models\StaffForm;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffFormController extends Controller
{
    public function index()
    {
        $collections = StaffForm::query()
            ->active();

        StaffFormResource::withoutWrapping();

        return Inertia::render('StaffForm/Index', [
            'data' => [
                'collections'   => StaffFormResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('StaffForm/Create', [
            'data' => $this->data(new StaffForm())
        ]);
    }

    public function store(Request $request)
    {
        // return $request;

        $staff_form = StaffForm::create($this->validatedData($request));

        return redirect()
            ->route('staff-form.show', $staff_form->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(StaffForm $staff_form)
    {
        // return $staff_form;

        $staff_form->load([
            'designation',
        ]);

        return Inertia::render('StaffForm/Show', [
            'data' => $this->data($staff_form),
        ]);
    }

    public function edit(StaffForm $staff_form)
    {
        if(request()->step == 'salary') {
            return Inertia::render('Staff/Edit', [
                'data'  => $this->data($staff_form),
                'step'  => 'salary',
            ]);
        }

        $staff_form->load([
            'designation',
        ]);

        return Inertia::render('StaffForm/Edit', [
            'data' => $this->data($staff_form)
        ]);
    }

    public function update(Request $request, StaffForm $staff_form)
    {
        $staff_form->update($this->validatedData($request, $staff_form->id));

        return redirect()
            ->route('staff-form.show', $staff_form->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(StaffForm $staff_form)
    {
        $staff_form->delete();

        return redirect()
            ->route('staff-form.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($staff_form)
    {
        DivisionResource::withoutWrapping();
        DistrictResource::withoutWrapping();
        AreaResource::withoutWrapping();
        DesignationResource::withoutWrapping();

        return [
            'staff'         => $this->formatedData($staff_form),
            'divisions'     => DivisionResource::collection(Division::orderBy('name')->get()),
            'districts'     => DistrictResource::collection(District::orderBy('name')->get()),
            'areas'         => AreaResource::collection(Area::orderBy('name')->get()),
            'designations'  => DesignationResource::collection(Designation::orderBy('priority')->get()),
            'bloodGroups'   => Student::getBloodGroups()
        ];
    }

    protected function formatedData($staff_form)
    {
        StaffFormResource::withoutWrapping();

        return StaffFormResource::make($staff_form);
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
            'date_of_birth' => [
                'required',
                'string',
            ],
            'phone' => [
                'required',
                'string',
            ],
            'alternative_phone' => '',
            'date_of_birth' => '',
            'blood_group' => '',
            'nid' => '',
            'gender' => [
                'required',
            ],
            'fathers_info' => [],
            'mothers_info' => [],
            'reference_info' => [],
            'present_address_info' => [],
            'permanent_address_info' => [],
            'is_same_address' => [],
            'educational_qualifications' => [],
            'previous_experience' => [],
            'designation_id' => [
                'required'
            ],
            'expected_salary' => [],
        ]);
    }

}
