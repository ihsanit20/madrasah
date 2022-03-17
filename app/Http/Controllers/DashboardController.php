<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() 
    {
        $counter = [
            "classes"       => Classes::count(),
            "students"      => Student::count(),
            "admissions"    => Admission::count(),
        ];

        return Inertia::render('Dashboard/Index', [
            "data" => [
                "counter" => $counter
            ]
        ]);
    }
}
