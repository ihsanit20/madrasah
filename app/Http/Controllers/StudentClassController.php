<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
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
}
