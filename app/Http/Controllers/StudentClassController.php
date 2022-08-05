<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentClassController extends Controller
{
    public function index()
    {
        $collections = Classes::query();

        ClassesResource::withoutWrapping();

        return Inertia::render('Student/Classes', [
            'data' => [
                'classes'       => ClassesResource::collection($collections->get()),
                'totalStudent'  => Student::active()->student()->count(),
            ]
        ]);
    }


    public function show(Classes $class)
    {
        ClassesResource::withoutWrapping();
        StudentResource::withoutWrapping();

        $students = Student::query()
            ->whereHas('current_admission', function($query) use ($class) {
                $query->where('class_id', $class->id);
            })
            ->active()
            ->student()
            ->get();

        return Inertia::render('Student/Index', [
            'data' => [
                'classes'   => new ClassesResource($class),
                'students'  => StudentResource::collection($students),
            ]
        ]);
    }

    public function idCard(Classes $class)
    {
        $students = Student::query()
            ->with([
                'father_info',
                'mother_info',
                'guardian_info',
                'present_address.area.district',
                // 'permanent_address.area.district',
                'current_admission',
            ])
            ->whereHas('current_admission', function($query) use ($class) {
                $query->where('class_id', $class->id);
            })
            ->active()
            ->student()
            ->get();

        $principal = Staff::query()
            ->with('signature')
            ->where('designation_id', 1)
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';

        StudentResource::withoutWrapping();

        return Inertia::render('Student/AllIdCard', [
            'students'  => StudentResource::collection($students),
            'signature' => $signature,
        ]);
    }
}
