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

    public function dashboard()
    {
        return Inertia::render('Dashboard/Home');
    }

    public function admission()
    {
        return Inertia::render('Dashboard/Admission/Index');
    }

    public function student()
    {
        return Inertia::render('Dashboard/Student/Index');
    }

    public function income()
    {
        return Inertia::render('Dashboard/Income/Index');
    }

    public function expence()
    {
        return Inertia::render('Dashboard/Expence/Index');
    }

    public function staff()
    {
        return Inertia::render('Dashboard/Staff/Index');
    }

    public function exam()
    {
        return Inertia::render('Dashboard/Exam/Index');
    }

    public function smsPanel()
    {
        return Inertia::render('Dashboard/SmsPanel/Index');
    }

    public function notice()
    {
        return Inertia::render('Dashboard/Notice/Index');
    }

    public function routine()
    {
        return Inertia::render('Dashboard/Routine/Index');
    }

    public function report()
    {
        return Inertia::render('Dashboard/Report/Index');
    }

    public function article()
    {
        return Inertia::render('Dashboard/Article/Index');
    }

    public function setting()
    {
        return Inertia::render('Dashboard/Setting/Index');
    }
}
