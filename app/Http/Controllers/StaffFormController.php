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
use App\Models\EducationalQualification;
use App\Models\Staff;
use App\Models\StaffForm;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StaffFormController extends Controller
{
    public function index()
    {
        $collections = StaffForm::query()
            ->current()
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

        $staff_form = StaffForm::create($this->validatedData($request) + [
            'session' => StaffForm::$current_session,
        ]);

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
        // return $this->data($staff_form);

        if(request()->step == 'salary') {
            return Inertia::render('StaffForm/Edit', [
                'data'  => $this->data($staff_form),
                'step'  => 'salary',
            ]);
        }

        if(request()->step == 'complete') {
            return Inertia::render('StaffForm/Edit', [
                'data'  => $this->data($staff_form),
                'step'  => 'complete',
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
        if($request->step == 'salary')
        {
            $staff_form->update([
                "default_salaries" => $request->default_salaries,
            ]);

            return redirect()
                ->route('staff-form.edit', [
                    $staff_form->id,
                    "step=complete"
                ]);
        }

        if($request->step == 'complete')
        {
            $staff = Staff::create([
                "name"  => $staff_form->name,
                "date_of_birth"  => $staff_form->date_of_birth,
                "phone"  => $staff_form->phone,
                "alternative_phone"  => $staff_form->alternative_phone,
                "nid"  => $staff_form->nid,
                "gender"  => $staff_form->gender,
                "blood_group"  => $staff_form->blood_group,
                "fathers_info"  => $staff_form->fathers_info,
                "mothers_info"  => $staff_form->mothers_info,
                "reference_info"  => $staff_form->reference_info,

                "present_address_info"  => $staff_form->present_address_info,
                "permanent_address_info"  => $staff_form->permanent_address_info,
            ]);

            // appointment : designation_id : default_salaries
            $appointment = Appointment::create([
                'staff_id'          => $staff->id,
                'session'           => Staff::$current_session,
                'designation_id'    => $staff_form->designation_id,
                'default_salaries'  => $staff_form->default_salaries,
            ]);

            // educational_qualifications
            if(count($staff_form->educational_qualifications))
            {
                foreach($staff_form->educational_qualifications as $educational_qualification)
                {
                    EducationalQualification::create([
                        "staff_id"          => $staff->id,
                        "exam_name"         => $educational_qualification["exam_name"],
                        "year"              => $educational_qualification["year"],
                        "institute_name"    => $educational_qualification["institute_name"],
                        "board"             => $educational_qualification["board"],
                        "result"            => $educational_qualification["result"],
                    ]);
                }
            }

            // update staff-form
            $staff_form->update([
                "status"        => 2,
                "staff_id"      => $staff->id,
                "complete_by"   => Auth::id(),
            ]);

            return redirect()
                ->route('staff.show', $staff->id);
        }
        
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
