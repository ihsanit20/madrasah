<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\StudentResource;
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
        // return $this->data(new Student());

        return Inertia::render('Student/Create', [
            'data' => $this->data(new Student())
        ]);
    }

    public function store(Request $request)
    {
        $father_info_id = $this->storeGuardianGetId($request->father_info);

        $mother_info_id = $this->storeGuardianGetId($request->mother_info);

        switch($request->guardianType) {
            case 1:
                $guardian_info_id = $father_info_id;
                break;

            case 2:
                $guardian_info_id = $mother_info_id;
                break;

            case 3:
                $guardian_info_id = $this->storeGuardianGetId($request->guardian_info);
                break;

            default:
                $guardian_info_id = null;
        }

        $validated_data = $this->validatedData($request);

        $student = Student::create(
            $validated_data + [
                'father_info_id'    => $father_info_id,
                'mother_info_id'    => $mother_info_id,
                'guardian_info_id'  => $guardian_info_id,
            ]
        );

        return $student;

        return redirect()
            ->route('students.show', $student->id)
            ->with('status', 'The record has been added successfully.');
    }

    protected function storeGuardianGetId($guardian, $old_selected_id = '')
    {
        if($old_selected_id) {
            Guardian::where('id', $old_selected_id)->delete();
        }

        $guardian = Guardian::onlyTrashed()->updateOrCreate(
            [],
            [
                'name'          => $guardian['name'] ?? null,
                'phone'         => $guardian['phone'] ?? null,
                'comment'       => $guardian['comment'] ?? null,
                'deleted_at'    => null,
            ]
        );

        return $guardian->id ?? null;
    }

    public function show(Student $student)
    {
        StudentResource::withoutWrapping();

        return Inertia::render('Student/Show', [
            'data' => [
                'student' => new StudentResource($student),
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

    private function data($student)
    {
        StudentResource::withoutWrapping();
        
        return [
            'student'   => new StudentResource($student),
            'divisions' => DivisionResource::collection(Division::orderBy('name')->get()),
            'districts' => DistrictResource::collection(District::orderBy('name')->get()),
            'areas'     => AreaResource::collection(Area::orderBy('name')->get()),
        ];
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