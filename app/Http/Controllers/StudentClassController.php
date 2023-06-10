<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\SimpleStudentResource;
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
        $collections = Classes::query()
            ->with('teacher', 'students');

        ClassesResource::withoutWrapping();

        return Inertia::render('Student/Classes', [
            'data' => [
                'classes'       => ClassesResource::collection($collections->get()),
                'totalStudent'  => Student::active()->student()->has('current_admission')->count(),
            ]
        ]);
    }


    public function show(Classes $class)
    {
        ClassesResource::withoutWrapping();
        SimpleStudentResource::withoutWrapping();

        $class->load([
            'students:id,name,registration',
            'students.current_admission:id,student_id,class_id,roll',
            'students.current_admission.class:id,name',
        ]);

        return Inertia::render('Student/Index', [
            'data' => [
                'classes'   => new ClassesResource($class),
                'students'  => SimpleStudentResource::collection($class->students),
            ]
        ]);
    }

    public function idCard(Classes $class)
    {
        // return
        $students = Student::query()
            ->with([
                'image',
                'father_info',
                'mother_info',
                'guardian_info',
                'present_address.area.district',
                // 'permanent_address.area.district',
                // 'current_admission',
            ])
            ->whereHas('current_admission', function($query) use ($class) {
                $query->where('class_id', $class->id);
            })
            ->active()
            ->student()
            ->get();        
            
        // return
        $students = $students->sortBy([
            'current_admission.roll'
        ]);

        $principal = Staff::query()
            ->with('signature')
            ->principal()
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

    public function allIdCard()
    {
        // return
        $students = Student::query()
            ->with([
                'image',
                'father_info',
                'mother_info',
                'guardian_info',
                'present_address.area.district',
                'current_admission',
            ])
            ->has('current_admission')
            ->active()
            ->student()
            ->get();

        // return
        $students = $students->sortBy([
            'current_admission.class_id',
            'current_admission.roll'
        ]);

        $principal = Staff::query()
            ->with('signature')
            ->principal()
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

    public function attendancePage(Classes $class)
    {
        // return
        $class->load([
            'current_admissions:id,student_id,class_id,student_id,status,roll',
            'current_admissions.student:id,name,registration,resident',
        ]);

        return Inertia::render('Student/AttendancePage', [
            'data' => [
                'class_info' => $class,
                'admissions' => $class->current_admissions,
            ],
        ]);
    }
}
