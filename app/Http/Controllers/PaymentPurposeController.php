<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentPurposeController extends Controller
{
    public function index()
    {
        return Inertia::render('Payment/Purpose', [
            'data' => [
                'purposes'      => Fee::getPurpose(),
                'totalStudent'  => Student::active()->student()->count(),
                'totalPayment'  => $this->purposeWiseTotalPayment(),
            ]
        ]);
    }

    public function show($purpose)
    {
        $collections = Classes::query();

        Fee::getPurpose($purpose);

        ClassesResource::withoutWrapping();

        return Inertia::render('Payment/Classes', [
            'data' => [
                'classes'       => ClassesResource::collection($collections->get()),
                'totalPayment'  => $this->purposeClassWiseTotalPayment($purpose),
                'purpose'       => Fee::getPurpose($purpose),
                'purposeId'     => (int) $purpose,
            ]
        ]);
    }

    public function classes($purpose, Classes $class)
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

        $students = $students->filter(function($student) use ($purpose) {
            return ! in_array($purpose, $student->payment_purpose);
        });

        return Inertia::render('Student/Index', [
            'data' => [
                'classes'   => new ClassesResource($class),
                'students'  => StudentResource::collection($students),
                'purposeId' => $purpose,
            ]
        ]);
    }

    protected function purposeWiseTotalPayment()
    {
        $purposes = Fee::getPurpose();

        $session = $this->getCurrentSession();

        $data = Array();

        foreach($purposes as $index => $purpose) {
            $data[$index] = Payment::query()
                ->with('admission:id,session')
                ->whereHas('admission', function ($query) {
                    $query->where('session', $this->getCurrentSession());
                })
                ->where('purpose', $index)
                ->count();
        }

        return $data;
    }

    protected function purposeClassWiseTotalPayment($purpose)
    {
        $classes = Classes::get();

        $data = Array();

        foreach($classes as $class) {
            $data[$class->id] = Payment::query()
                ->with('admission:id,session,class_id')
                ->whereHas('admission', function ($query) use ($class) {
                    $query->where([
                        'session'   => $this->getCurrentSession(),
                        'class_id'  => $class->id,
                    ]);
                })
                ->where('purpose', $purpose)
                ->count();
        }

        return $data;
    }
}
