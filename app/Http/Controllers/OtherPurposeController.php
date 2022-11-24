<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\Purpose;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OtherPurposeController extends Controller
{
    public function index()
    {
        return Inertia::render('Other/Purpose', [
            'data' => [
                'purposes'      => Purpose::get(),
                // 'totalStudent'  => Student::active()->student()->count(),
                // 'totalStudent'  => $this->purposeWiseTotalStudent(),
                // 'totalPayment'  => $this->purposeWiseTotalPayment(),
            ]
        ]);
    }

    public function show(Purpose $purpose)
    {
        $purpose->load([
            'purpose_fees',
        ]);

        $collections = Classes::query()
            ->whereIn('id', $purpose->purpose_fees->pluck('class_id'))
            ->with([
                'students',
                'teacher',
            ]);

        ClassesResource::withoutWrapping();

        return Inertia::render('Other/Classes', [
            'data' => [
                'classes'       => ClassesResource::collection($collections->get()),
                'totalPayment'  => $this->purposeClassWiseTotalPayment($purpose),
                'purpose'       => $purpose,
                'purposeId'     => (int) $purpose->id,
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

        $due_students = $students->filter(function($student) use ($purpose) {
            return ! in_array($purpose, $student->payment_purpose);
            // return ($student->due_purpose_id == $purpose && $student->due > 0) || ! in_array($purpose, $student->payment_purpose);
        });

        $paid_students = $students->filter(function($student) use ($purpose) {
            return in_array($purpose, $student->payment_purpose);
        });

        return Inertia::render('Student/Index', [
            'data' => [
                'classes'       => new ClassesResource($class),
                'students'      => StudentResource::collection($due_students),
                'paidStudents'  => StudentResource::collection($paid_students),
                'purposeId'     => $purpose,
            ]
        ]);
    }

    protected function purposeWiseTotalStudent()
    {
        $purposes = Purpose::query()
            ->with([
                'purpose_fees',
            ])
            ->get();

        $data = Array();

        foreach($purposes as $purpose) {

            $data[$purpose->id] = Student::query()
                ->active()
                ->student()
                ->whereHas('current_admission', function($query) use ($purpose) {
                    $query->whereIn('class_id', $purpose->purpose_fees->pluck('class_id'));
                })
                ->count();
        }

        return $data;
    }

    protected function purposeWiseTotalPayment()
    {
        $purposes = Purpose::get();

        $data = Array();

        foreach($purposes as $purpose) {
            $index = $purpose->id;


            $payments = Payment::query()
                ->with([
                    'admission:id,session,student_id',
                    'admission.student:id',
                ])
                ->whereHas('admission', function ($query) {
                    $query->where('session', $this->getCurrentSession());
                })
                ->orWhereJsonContains('purposes', $index)
                ->get();
                
            $payments = $payments->filter(function($payment) use ($index) {
                return ! (($payment->admission->student->due_purpose_id ?? 0) == $index && ($payment->admission->student->due ?? 0) > 0);
            });

            $data[$index] = $payments->groupBy(['admission_id', 'purpose'])->count() ?? 0;
        }

        return $data;
    }

    protected function purposeClassWiseTotalPayment($purpose)
    {
        $classes = Classes::latest()->get();

        $data = Array();

        foreach($classes as $class) {
            $payments = Payment::query()
                ->with([
                    'admission:id,session,class_id,student_id',
                    'admission.student:id',
                ])
                ->whereHas('admission', function ($query) use ($class) {
                    $query
                        ->where([
                            'session'   => $this->getCurrentSession(),
                            'class_id'  => $class->id,
                        ]);
                })
                ->get();

            $payments = $payments->filter(function($payment) use ($purpose) {
                return in_array($purpose->id, $payment->purposes ?? []);
            });
            
            // $payments = $payments->filter(function($payment) use ($purpose) {
            //     return ! (($payment->admission->student->due_purpose_id ?? 0) == $purpose->id && ($payment->admission->student->due ?? 0) > 0);
            // });

            $data[$class->id] = $payments->groupBy(['admission_id'])->count();
        }

        return $data;
    }
}
