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
        $student = Student::create(
            $this->validatedData($request)
            + $this->storeGuardian($request)
            + $this->storeAddress($request)
        );

        return redirect()
            ->route('students.show', $student->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Student $student)
    {
        // return $this->formatedData($student);

        return Inertia::render('Student/Show', [
            'data' => [
                'student' => $this->formatedData($student),
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
        $student->update(
            $this->validatedData($request, $student->id)
            + $this->storeGuardian($request, $student)
            + $this->storeAddress($request, $student)
        );

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
            'student'   => $this->formatedData($student),
            'divisions' => DivisionResource::collection(Division::orderBy('name')->get()),
            'districts' => DistrictResource::collection(District::orderBy('name')->get()),
            'areas'     => AreaResource::collection(Area::orderBy('name')->get()),
        ];
    }

    protected function formatedData($student)
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

    protected function validatedData($request, $id = '')
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
                'deleted_at'    => null,
            ]
        );

        return $response->id ?? null;
    }

}