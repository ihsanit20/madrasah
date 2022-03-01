<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\StudentResource;
use App\Models\Address;
use App\Models\Area;
use App\Models\District;
use App\Models\Division;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index()
    {
        $collections = Student::query();

        return Inertia::render('Student/Index', [
            'data' => [
                'collections'   => StudentResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Student/Create', [
            'data' => $this->data(new Student())
        ]);
    }

    public function store(Request $request)
    {
        $father_info_id = $this->storeGuardianGetId($request->father_info);

        $mother_info_id = $this->storeGuardianGetId($request->mother_info);

        if ($request->guardianType == 1) {
            $guardian_info_id = $father_info_id;
        } 
        elseif ($request->guardianType == 2) {
            $guardian_info_id = $father_info_id;
        }
        else {
            $guardian_info_id = $this->storeGuardianGetId($request->guardian_info);
        }

        $present_address_id = $this->storeAddressGetId($request->present_address);

        $permanent_address_id = $request->is_same_address
            ? $present_address_id
            : $this->storeAddressGetId($request->permanent_address);

        $validated_data = $this->validatedData($request);

        $student = Student::create(
            $validated_data + [
                'father_info_id'    => $father_info_id,
                'mother_info_id'    => $mother_info_id,
                'guardian_info_id'  => $guardian_info_id,
            ] + [
                'present_address_id'    => $present_address_id,
                'permanent_address_id'  => $permanent_address_id,
            ]
        );

        return $student;

        return redirect()
            ->route('students.show', $student->id)
            ->with('status', 'The record has been added successfully.');
    }

    protected function storeGuardianGetId($guardian, $old_id = '')
    {
        if($old_id) {
            Guardian::where('id', $old_id)->delete();
        }

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
                'deleted_at'    => null,
            ]
        );

        return $response->id ?? null;
    }

    public function show(Student $student)
    {
        return $this->GetStudentResourceData($student);

        return Inertia::render('Student/Show', [
            'data' => [
                'student' => $this->GetStudentResourceData($student),
            ]
        ]);
    }

    public function edit(Student $student)
    {
        return Inertia::render('Student/Edit', [
            'data' => $this->data($student)
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $student->update($this->validatedData($request, $student->id));

        return redirect()
            ->route('students.show', $student->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($student)
    {
        return [
            'student'   => $this->GetStudentResourceData($student),
            'divisions' => DivisionResource::collection(Division::orderBy('name')->get()),
            'districts' => DistrictResource::collection(District::orderBy('name')->get()),
            'areas'     => AreaResource::collection(Area::orderBy('name')->get()),
        ];
    }

    protected function GetStudentResourceData($student)
    {
        StudentResource::withoutWrapping();

        return new StudentResource(
            $student->load([
                'father_info',
                'mother_info',
                'guardian_info',
                'present_address.area.district.division',
                'permanent_address.area.district.division',
            ]
        ));
    }

    protected function getFilterProperty()
    {
        return [
            //
        ];
    }

    private function validatedData($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
            ],
            'date_of_birth' => '',
            'gender' => '',
            'birth_certificate' => '',
        ]);
    }

}