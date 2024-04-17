<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;
use App\Http\Resources\DesignationResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\StaffResource;
use App\Models\Address;
use App\Models\Appointment;
use App\Models\Area;
use App\Models\Designation;
use App\Models\District;
use App\Models\Division;
use App\Models\EducationalQualification;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StaffController extends Controller
{
    public function list()
    {
        $collections = Staff::query();

        return 
        $collections
            ->first();

        return Inertia::render('Staff/List', [
            'data' => [
                'collections'   => StaffResource::collection($collections->with('current_appointment')->has('current_appointment')->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    private function getStaffQuery()
    {
        return Staff::query()
            ->select([
                'staff.id as staff_id',
                'staff.name as name',
                'designations.name as designation',
            ])
            ->leftJoin('appointments', function($join) {
                $join->on('appointments.staff_id', '=', 'staff.id');
                $join->on('appointments.session', '=', DB::raw("'" . Staff::$current_session . "'"));
            })
            ->join('designations', 'designations.id', 'appointments.designation_id')
            ->orderBy('designations.priority')
            ->where('appointments.active', 1)
            ;
    }

    private function getMaleStaffData()
    {
        return $this->getStaffQuery()
            ->male()
            ->get();
    }

    private function getFemaleStaffData()
    {
        return $this->getStaffQuery()
            ->female()
            ->get();
    }

    public function attendancePage()
    {
        // return
        $male_staff = $this->getMaleStaffData();

        // return
        $female_staff = $this->getFemaleStaffData();

        return Inertia::render('Staff/AttendancePage', [
            'data' => [
                'male_staff'    => $male_staff,
                'female_staff'  => $female_staff,
            ],
        ]);
    }

    public function appointmentDuplicateToCurrentSession()
    {
        // return
        $exists_current_session_appointment = Appointment::query()
            ->where('session', Staff::$current_session)
            ->exists();

        if(!$exists_current_session_appointment) {
            // return
            $appointments = Appointment::query()
                ->where([
                    'session'   => Staff::$previous_session,
                    'active'    => 1,
                ])
                ->get();
        
            foreach($appointments as $appointment) {
                Appointment::create([
                    'staff_id'          => $appointment->staff_id,
                    'session'           => Staff::$current_session,
                    'designation_id'    => $appointment->designation_id,
                    'default_salaries'  => $appointment->default_salaries,
                    'active'            => 1,
                ]);
            }

        }
    }

    public function index()
    {
        $collections = Staff::query()
            ->with('current_appointment.designation')
            ->has('current_appointment');

        if(!$collections->exists()) {
            // return 
            $this->appointmentDuplicateToCurrentSession();
        }

        $staff = $collections->get();

        StaffResource::withoutWrapping();

        return Inertia::render('Staff/Index', [
            'data' => [
                'staff'     => StaffResource::collection($staff),
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
            'educational_qualifications',
        ]);

        // return $staff;

        // return $this->formatedData($staff);

        return Inertia::render('Staff/Show', [
            'data' => [
                'staff'     => $this->formatedData($staff),
                'divisions' => DivisionResource::collection(Division::orderBy('name')->get()),
                'districts' => DistrictResource::collection(District::orderBy('name')->get()),
                'areas'     => AreaResource::collection(Area::orderBy('name')->get()),
            ]
        ]);
    }

    public function edit(Staff $staff)
    {
        if(request()->step == 'salary') {
            // return $this->data($staff);

            return Inertia::render('Staff/Edit', [
                'data'  => $this->data($staff),
                'step'  => 'salary',
            ]);
        }

        if(request()->step == 'education') {
            $staff->load('educational_qualifications');
    
            // return $this->formatedData($staff);

            return Inertia::render('Staff/Edit', [
                'data'  => [
                    'staff' => $this->formatedData($staff),
                ],
                'step'  => 'education',
            ]);
        }

        if(request()->step == 'basic') {
            // return $this->formatedData($staff);

            return Inertia::render('Staff/Edit', [
                'data'  => $this->data($staff),
                'step'  => 'basic',
            ]);
        }

        return redirect()
            ->route('staff.show', $staff->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function update(Request $request, Staff $staff)
    {
        if($request->step == 'salary')
        {
            $staff->current_appointment()->update([
                "default_salaries" => $request->default_salaries,
            ]);
        }
        elseif($request->step == 'education')
        {
            $this->storeEducationalQualification($request, $staff);
        }
        elseif($request->step == 'current_appointment_active_status')
        {
            $staff->current_appointment()->update([
                "active" => $request->active
            ]);

            return response([
                "message" => "success",
                "active" => (boolean) ($staff->current_appointment->active ?? false),
            ]);
        }
        elseif($request->step == 'basic')
        {
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

    public function staffIdCard()
    {
        $collections = Staff::query()
            ->with('current_appointment.designation')
            ->has('current_appointment')
            ->whereHas('current_appointment', function($query) {
                $query->where('active', 1);
            });

        StaffResource::withoutWrapping();

        $principal = Staff::query()
            ->with('signature')
            ->principal()
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';

        // return StaffResource::collection($collections->get());

        // return
        $staff_list = $collections->get();

        $staff_list = $staff_list->sortBy('current_appointment.designation.priority');

        return Inertia::render('Staff/AllIdCard', [
            'signature' => $signature,
            'staffList' => StaffResource::collection($staff_list),
            'data'      => [
                'divisions' => DivisionResource::collection(Division::orderBy('name')->get()),
                'districts' => DistrictResource::collection(District::orderBy('name')->get()),
                'areas'     => AreaResource::collection(Area::orderBy('name')->get()),
            ],
        ]);
    }

    protected function data($staff)
    {
        DesignationResource::withoutWrapping();
        DivisionResource::withoutWrapping();
        DistrictResource::withoutWrapping();
        AreaResource::withoutWrapping();

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
            'joining_date' => [],
        ]);
    }

    protected function storeEducationalQualification($request, $staff)
    {
        $staff->load('educational_qualifications');

        $staff->educational_qualifications()->delete();

        if(count($request->educational_qualifications))
        {
            foreach($request->educational_qualifications as $educational_qualification)
            {
                EducationalQualification::onlyTrashed()->updateOrCreate(
                    [

                    ],
                    [
                        "staff_id"          => $staff->id,
                        "exam_name"         => $educational_qualification["exam_name"],
                        "year"              => $educational_qualification["year"],
                        "institute_name"    => $educational_qualification["institute_name"],
                        "board"             => $educational_qualification["board"],
                        "result"            => $educational_qualification["result"],
                        "deleted_at"        => null,
                    ]
                );
            }
        }
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