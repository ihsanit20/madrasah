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
            "students"      => Student::student()->count(),
            "staff"         => Staff::count(),
            "admissions"    => Admission::count(),
            "notices"       => Notice::count(),
            "admins"        => User::count(),
            "payments"      => Payment::count(),
            "expenses"      => Expense::count(),
        ];

        return Inertia::render('Dashboard/Index', [
            "data" => [
                "counter" => $counter
            ]
        ]);
    }
}
