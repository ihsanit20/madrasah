<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdmissionResource;
use App\Http\Resources\AreaResource;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\StudentResource;
use App\Models\Address;
use App\Models\Admission;
use App\Models\Area;
use App\Models\Classes;
use App\Models\District;
use App\Models\Division;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AdmissionController extends Controller
{
    public function index()
    {
        $collections = Admission::query()
            ->with('student.father_info');

        return Inertia::render('Admission/Index', [
            'data' => [
                'collections'   => AdmissionResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Admission/Create', [
            'data' => $this->data(new Admission())
        ]);
    }

    public function store(Request $request)
    {
        // return $request;

        $student = Student::create(
            $this->validatedStudentData($request)
            + $this->storeGuardian($request)
            + $this->storeAddress($request)
        );

        $admission = $student->admissions()->create(
            $this->validatedAdmissionData($request)
            // + $this->getArrayOfNewClassRoll($student->id, $request->class_id)
            + $this->getArrayOfSession($request->session)
        );


        return redirect()
            ->route('admissions.show', $admission->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Admission $admission)
    {
        $student = $admission->student->first();

        AdmissionResource::withoutWrapping();

        return Inertia::render('Admission/Show', [
            'data' => [
                'admission' => $this->formatedData($admission),
                'student'   => $this->formatedStudentData($student),
            ]
        ]);
    }

    public function edit(Admission $admission)
    {
        return Inertia::render('Admission/Edit', [
            'data' => $this->data($admission)
        ]);
    }

    public function update(Request $request, Admission $admission)
    {
        // return $request;

        $student = $admission->student()->first();

        $student->update(
            $this->validatedStudentData($request, $student->id)
            + $this->storeGuardian($request, $student)
            + $this->storeAddress($request, $student)
        );

        $admission->update($this->validatedAdmissionData($request, $admission->id));

        return redirect()
            ->route('admissions.show', $admission->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Admission $admission)
    {
        // $admission->delete();

        return redirect()
            ->route('admissions.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($admission)
    {
        $student = $admission->student()->first() ?? new Student();
    
        return [
            'admission'     => $this->formatedData($admission),
            'student'       => $this->formatedStudentData($student),
            'divisions'     => DivisionResource::collection(Division::orderBy('name')->get()),
            'districts'     => DistrictResource::collection(District::orderBy('name')->get()),
            'areas'         => AreaResource::collection(Area::orderBy('name')->get()),
            'classes'       => ClassesResource::collection(Classes::get()),
            'bloodGroups'   => Student::getBloodGroups(),
            'residentArray' => Student::getResidentArrayData(),
        ];
    }

    protected function formatedData($admission)
    {
        AdmissionResource::withoutWrapping();

        return new AdmissionResource($admission);
    }

    protected function formatedStudentData($student)
    {
        StudentResource::withoutWrapping();

        return new StudentResource(
            $student->load([
                'father_info',
                'mother_info',
                'guardian_info',
                'present_address.area.district',
                'permanent_address.area.district',
            ]
        ));
    }

    protected function getFilterProperty()
    {
        return [
            //
        ];
    }

    protected function validatedStudentData($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
            ],
            'date_of_birth' => '',
            'gender' => '',
            'resident' => [
                'required',
            ],
            'blood_group' => '',
            'birth_certificate' => '',
        ]);
    }

    protected function validatedAdmissionData($request, $id = '')
    {
        return $request->validate([
            // 'session' => [
            //     'required',
            //     'string',
            // ],
            'class_id' => [
                'required',
                'numeric',
            ],
        ]);
    }

    protected function storeGuardian($request, $student = null)
    {
        if($student) {
            Guardian::query()
                ->whereIn('id', [
                    $student->father_info_id,
                    $student->mother_info_id,
                    $student->guardian_info_id
                ])
                ->delete();
        }

        $father_info_id = $this->storeGuardianGetId($request->father_info);

        $mother_info_id = $this->storeGuardianGetId($request->mother_info);

        if ($request->guardian_type == 1) {
            $guardian_info_id = $father_info_id;
        } 
        elseif ($request->guardian_type == 2) {
            $guardian_info_id = $mother_info_id;
        }
        else {
            $guardian_info_id = $this->storeGuardianGetId($request->guardian_info);
        }

        return [
            'father_info_id'    => $father_info_id,
            'mother_info_id'    => $mother_info_id,
            'guardian_info_id'  => $guardian_info_id,
        ];
    }

    protected function storeAddress($request, $student = null)
    {
        if($student) {
            Address::query()
                ->whereIn('id', [
                    $student->present_address_id,
                    $student->permanent_address_id
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

    protected function storeGuardianGetId($guardian, $old_id = '')
    {
        $response = Guardian::onlyTrashed()->updateOrCreate(
            [],
            [
                'name'          => $guardian['name'] ?? null,
                'phone'         => $guardian['phone'] ?? null,
                'occupation'    => $guardian['occupation'] ?? null,
                'relation'      => $guardian['relation'] ?? null,
                'deleted_at'    => null,
            ]
        );

        return $response->id ?? null;
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

    protected function getArrayOfNewClassRoll($student_id, $class_id, $session = null)
    {
        return [
            "roll" => $this->getLastClassRoll($student_id, $class_id, $session) + 1
        ];
    }

    protected function getLastClassRoll($student_id, $class_id, $session = null)
    {
        $session = $session_id ?? $this->getCurrentSession();

        $last_class_roll = 0;

        $last_class_roll = Admission::query()
            ->where([
                'student_id'    => $student_id,
                'class_id'      => $class_id,
                'session'       => $session
            ])
            ->value('roll');

        return $last_class_roll;
    }

    protected function getCurrentSession()
    {
        return "43-44";
    }

    protected function getArrayOfSession($session = null)
    {
        return [
            "session" => $session ?? $this->getCurrentSession()
        ];
    }

}