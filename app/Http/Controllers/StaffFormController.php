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

        // return $collections->paginate();

        return Inertia::render('StaffForm/Index', [
            'data' => [
                'collections'   => StaffFormResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
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
        // return $request;

        $staff = Staff::create(
            $this->validatedData($request)
            + $this->storeAddress($request)
        );

        return redirect()
            ->route('staff.show', $staff->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Staff $staff)
    {
        // return $staff;

        $staff->load([
            'current_appointment.designation',
        ]);

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

        $staff->load([
            'present_address',
            'permanent_address',
        ]);

        // return $this->data($staff);

        return Inertia::render('Staff/Edit', [
            'data' => $this->data($staff)
        ]);
    }

    public function update(Request $request, Staff $staff)
    {
        if($request->step == 'salary') {
            $staff->update([
                "default_salaries" => $request->default_salaries,
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
            'staff'         => $this->formatedData($staff),
            'divisions'     => DivisionResource::collection(Division::orderBy('name')->get()),
            'districts'     => DistrictResource::collection(District::orderBy('name')->get()),
            'areas'         => AreaResource::collection(Area::orderBy('name')->get()),
            'designations'  => DesignationResource::collection(Designation::get()),
            'bloodGroups'   => Student::getBloodGroups()
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
            // 'designation_id' => [
            //     'required',
            //     'numeric',
            // ],
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
            'father_info' => [
                'required',
            ],
            'mother_info' => [
                'required',
            ],
            'reference' => [
                'required',
            ],
        ]);
    }

    
    protected function storeAddress($request, $staff = null)
    {
        if($staff) {
            Address::query()
                ->whereIn('id', [
                    $staff->present_address_id,
                    $staff->permanent_address_id
                ])
                ->delete();
        }

        $present_address_id = $this->storeAddressGetId($request->present_address);

        $permanent_address_id = $request->is_same_address
            ? $present_address_id
            : $this->storeAddressGetId($request->permanent_address);

        return [
            'present_address_id'    => $present_address_id,
            'permanent_address_id'  => $permanent_address_id,
        ];
    }
    
    protected function storeAddressGetId($address, $old_id = '')
    {
        if($old_id) {
            Address::where('id', $old_id)->delete();
        }

        $response = Address::onlyTrashed()->updateOrCreate(
            [],
            [
                'area_id'       => $address['area'] ?? null,
                'value'         => $address['address'] ?? null,
                'postoffice'    => $address['postoffice'] ?? null,
                'deleted_at'    => null,
            ]
        );

        return $response->id ?? null;
    }

}