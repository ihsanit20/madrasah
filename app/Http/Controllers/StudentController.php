<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdmissionResource;
use App\Http\Resources\AreaResource;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\ClassFeeResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\SimpleStudentResource;
use App\Http\Resources\StudentResource;
use App\Models\Address;
use App\Models\Admission;
use App\Models\Area;
use App\Models\Classes;
use App\Models\ClassFee;
use App\Models\District;
use App\Models\Division;
use App\Models\Guardian;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index()
    {
        $collections = Student::query()
            ->with([
                'current_admission:id,class_id,roll',
                'current_admission.class:id,name',
            ])
            ->latest()
            ->student();

        SimpleStudentResource::withoutWrapping();

        return Inertia::render('Student/Index', [
            'data' => [
                'students'      => SimpleStudentResource::collection($collections->get(['id', 'name', 'registration'])),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Student/Create', [
            'data' => $this->data(new Student())
        ]);
    }

    public function store(Request $request)
    {
        return $request;
        $student = Student::create(
            $this->validatedData($request)
            + $this->storeGuardian($request)
            + $this->storeAddress($request)
        );

        return redirect()
            ->route('students.show', $student->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Student $student)
    {
        return Inertia::render('Student/Show', [
            'data' => [
                'student'   => $this->formatedData($student),
                // 'admission' => $this->formatedAdmissionData($student->current_admission),
            ]
        ]);
    }

    public function edit(Student $student)
    {
        if(request()->step == 'fee') {
            AdmissionResource::withoutWrapping();

            $admission = $student->current_admission()->first();

            return Inertia::render('Student/Edit', [
                'data'  => [
                    'student'       => $this->formatedData($student),
                    'admission'     => new AdmissionResource($admission),
                    'yearlyFees'    => $this->getClassFee($admission->class_id, 1, $student->resident),
                    'monthlyFees'   => $this->getClassFee($admission->class_id, 2, $student->resident),
                ],
                'step'  => 'fee',
            ]);
        }

        return Inertia::render('Student/Edit', [
            'data' => $this->data($student)
        ]);
    }

    
    protected function getClassFee($class_id, $period = null, $resident = null)
    {
        ClassFeeResource::withoutWrapping();

        $query = ClassFee::query()
            ->where('class_id', $class_id)
            ->where(function ($query) use ($period) {
                $query->when($period, function ($query) use ($period) {
                    $query->whereHas('fee', function ($query) use ($period) {
                        $query->where('period', $period);
                    });
                });
            });
        
        $class_fees = $query->get();

        if($resident) {
            $class_fees = $class_fees->filter(function ($class_fee) use ($resident) {
                return in_array($resident, json_decode($class_fee->package));
            });
        }

        return ClassFeeResource::collection($class_fees);
    }

    public function update(Request $request, Student $student)
    {
        if($request->step == 'fee') {
            $student->current_admission()->update([
                "completed_by"  => Auth::id(),
                "concessions"   => json_encode($request->fees),
            ]);
        } else {
            $student->update(
                $this->validatedData($request, $student->id)
                + $this->storeGuardian($request, $student)
                + $this->storeAddress($request, $student)
            );
        }

        return redirect()
            ->route('students.show', $student->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($student)
    {
        return [
            'student'       => $this->formatedData($student),
            'divisions'     => DivisionResource::collection(Division::orderBy('name')->get()),
            'districts'     => DistrictResource::collection(District::orderBy('name')->get()),
            'areas'         => AreaResource::collection(Area::orderBy('name')->get()),
            'classes'       => ClassesResource::collection(Classes::get()),
            'bloodGroups'   => Student::getBloodGroups()
        ];
    }

    protected function formatedData($student)
    {
        StudentResource::withoutWrapping();

        return new StudentResource(
            $student->load([
                'father_info',
                'mother_info',
                'guardian_info',
                'present_address.area.district.division',
                'permanent_address.area.district.division',
            ]
        ));
    }

    protected function formatedAdmissionData($admission)
    {
        AdmissionResource::withoutWrapping();

        return new AdmissionResource($admission);
    }

    protected function getFilterProperty()
    {
        return [
            //
        ];
    }

    protected function validatedData($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
            ],
            'date_of_birth' => '',
            'gender' => '',
            'blood_group' => '',
            'birth_certificate' => '',
            'resident'  => ''
        ]);
    }

    protected function storeGuardian($request, $student = null)
    {
        if($student) {
            Guardian::query()
                ->whereIn('id', [
                    $student->father_info_id,
                    $student->mother_info_id,
                    $student->guardian_info_id
                ])
                ->delete();
        }

        $father_info_id = $this->storeGuardianGetId($request->father_info);

        $mother_info_id = $this->storeGuardianGetId($request->mother_info);

        if ($request->guardian_type == 1) {
            $guardian_info_id = $father_info_id;
        } 
        elseif ($request->guardian_type == 2) {
            $guardian_info_id = $mother_info_id;
        }
        else {
            $guardian_info_id = $this->storeGuardianGetId($request->guardian_info);
        }

        return [
            'father_info_id'    => $father_info_id,
            'mother_info_id'    => $mother_info_id,
            'guardian_info_id'  => $guardian_info_id,
        ];
    }

    protected function storeAddress($request, $student = null)
    {
        $old_present_address_id = '';
        $old_permanent_address_id = '';

        if($student) {
            Address::query()
                ->whereIn('id', [
                    $student->present_address_id,
                    $student->permanent_address_id
                ])
                ->delete();
            
            $old_present_address_id = $student->present_address_id;
            $old_permanent_address_id = $student->permanent_address_id;
        }

        $present_address_id = $this->storeAddressGetId($request->present_address, $old_present_address_id);

        $permanent_address_id = $request->is_same_address
            ? $present_address_id
            : $this->storeAddressGetId($request->permanent_address, $old_permanent_address_id);

        return [
            'present_address_id'    => $present_address_id,
            'permanent_address_id'  => $permanent_address_id,
        ];
    }

    protected function storeGuardianGetId($guardian, $old_id = '')
    {
        $response = Guardian::onlyTrashed()->updateOrCreate(
            [],
            [
                'name'          => $guardian['name'] ?? null,
                'phone'         => $guardian['phone'] ?? null,
                'occupation'    => $guardian['occupation'] ?? null,
                'relation'      => $guardian['relation'] ?? null,
                'deleted_at'    => null,
            ]
        );

        return $response->id ?? null;
    }

    protected function storeAddressGetId($address, $old_id = '')
    {
        if($old_id) {
            Address::where('id', $old_id)->delete();
        }

        $response = Address::onlyTrashed()->updateOrCreate(
            [],
            [
                'area_id'       => $address['area'] ?? null,
                'value'         => $address['address'] ?? null,
                'deleted_at'    => null,
            ]
        );

        return $response->id ?? null;
    }

    protected function getArrayOfNewClassRoll($student_id, $class_id, $session = null)
    {
        return [
            "roll" => $this->getLastClassRoll($student_id, $class_id, $session) + 1
        ];
    }

    protected function getLastClassRoll($student_id, $class_id, $session = null)
    {
        $session = $session_id ?? $this->getCurrentSession();

        $last_class_roll = 0;

        $last_class_roll = Admission::query()
            ->where([
                'student_id'    => $student_id,
                'class_id'      => $class_id,
                'session'       => $session
            ])
            ->value('roll');

        return $last_class_roll;
    }

    protected function getCurrentSession()
    {
        return "Ramadan 1443 - Shaban 1444";
    }

    protected function getArrayOfSession($session = null)
    {
        return [
            "session" => $session ?? $this->getCurrentSession()
        ];
    }

    public function idCard(Student $student)
    {
        $principal = Staff::query()
            ->with('signature')
            ->where('designation_id', 1)
            ->first();

        $signature = $principal
            ? ($principal->signature->url ?? '')
            : '';

        return Inertia::render('Student/IdCard', [
            'data' => [
                'student' => $this->formatedData($student),
            ],
            'signature' => $signature,
        ]);
    }

    public function moneyReceipt(Student $student)
    {
        $collections = $student->current_admission()
            ->first()
            ->payments()
            ->latest('id')
            ->with('admission')
            ->paginate()
            ->appends(request()->input());

        StudentResource::withoutWrapping();

        return Inertia::render('Student/MoneyReceipt', [
            'data' => [
                'collections'   => PaymentResource::collection($collections),
                'student'       => StudentResource::make($student)
            ]
        ]);
    }

    public function moneyReceiptShow(Student $student, Payment $payment)
    {
        $payment->load([
            'admission',
            'payment_details',
        ]);

        PaymentResource::withoutWrapping();
        
        return Inertia::render('Payment/Show', [
            'data' => [
                'payment' => PaymentResource::make($payment)
            ]
        ]);
    }

}