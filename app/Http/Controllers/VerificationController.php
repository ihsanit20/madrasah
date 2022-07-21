<?php

namespace App\Http\Controllers;

use App\Http\Resources\AreaResource;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\StudentResource;
use App\Models\Area;
use App\Models\Classes;
use App\Models\District;
use App\Models\Division;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerificationController extends Controller
{
    public function studentIdCard(Student $student, $admission_id)
    {
        $student->load('current_admission');

        if($student->current_admission->id != $admission_id) {
            return abort(404);
        }

        $principal = Staff::query()
            ->with('signature')
            ->where('designation_id', 1)
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';

        return Inertia::render('Verification/StudentIdCard', [
            'data' => $this->studentData($student),
            'signature' => $signature,
        ]);
    }

    protected function studentData($student)
    {
        return [
            'student'       => $this->studentFormatedData($student),
            'divisions'     => DivisionResource::collection(Division::orderBy('name')->get()),
            'districts'     => DistrictResource::collection(District::orderBy('name')->get()),
            'areas'         => AreaResource::collection(Area::orderBy('name')->get()),
            'classes'       => ClassesResource::collection(Classes::get()),
            'bloodGroups'   => Student::getBloodGroups()
        ];
    }

    protected function studentFormatedData($student)
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
}
