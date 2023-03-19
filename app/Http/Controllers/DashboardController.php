<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Classes;
use App\Models\Expense;
use App\Models\Notice;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() 
    {
        $counter = [
            "classes"       => Classes::count(),
            "students"      => Student::has('current_admission')->student()->count(),
            "staff"         => Staff::count(),
            "admissions"    => Admission::admission()->current()->count(),
            "notices"       => Notice::count(),
            "admins"        => User::count(),
            "expenses"      => Expense::current()->count(),
            "payments"      => Payment::has('current_admission')->count(),
        ];

        return Inertia::render('Dashboard/Index', [
            "data" => [
                "counter" => $counter
            ]
        ]);
    }
}
