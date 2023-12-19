<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdmissionResource;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\ClassFeeResource;
use App\Http\Resources\PaymentIndexResource;
use App\Http\Resources\PaymentResource;
use App\Models\Admission;
use App\Models\Classes;
use App\Models\ClassFee;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Purpose;
use App\Models\PurposeFee;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index()
    {
        $collections = Payment::query()
            ->has('current_admission')
            ->search(['id'],['admission.student:name'])
            ->filter(request())
            ->latest('id')
            ->with([
                'admission:id,student_id,class_id,roll',
                'admission.class:id,name',
                'admission.student:id,name',
                'admission.student.current_admission',
            ]);

        // return PaymentIndexResource::collection($collections->paginate(request()->perpage)->appends(request()->input()));

        return Inertia::render('Payment/Index', [
            'data' => [
                'collections'   => PaymentIndexResource::collection($collections->paginate(request()->perpage)->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function yearly()
    {
        return $this->index(1);
    }

    public function monthly()
    {
        return $this->index(2);
    }

    public function create()
    {
        // return request();

        AdmissionResource::withoutWrapping();

        ClassesResource::withoutWrapping();

        // return
        $admission = Admission::query()
            ->with([
                'class',
                'student',
                'verified_by_admin',
            ])
            ->current()
            ->student()
            ->find(request()->admission);

        $purposes = Fee::getPurpose();

        $other_purposes = Purpose::query()
            ->with('purpose_fees')
            ->get();

        foreach($other_purposes as $purpose) {
            $purposes[$purpose->id] = [
                "period"    => 3,
                "title"     => $purpose->title ?? '',
                "monthId"   => "",
                "classIds"  => $purpose->purpose_fees->pluck('class_id')->toArray(),
            ];
        }

        // return $purposes;

        $periods = Fee::getPeriod();

        if(request()->is_multiple_purpose === 'true') {

            $fees = [];

            foreach(request()->purposes ?? [] as $purpose) {

                $purpose_array = in_array($purpose, array_keys($purposes)) ? $purposes[$purpose] : "";
        
                $purpose_text = $purpose_array["title"] ?? "";
                
                $period = $purpose_array["period"] ?? null;
                
                if($admission && $period && $purpose) {
                    $fees[] = [
                        "name"   => $purpose_text,
                        "amount" => $this->getAvailableTotalAmount($admission, $period, $purpose),
                    ];
                }
            }

            return Inertia::render('Payment/Create', [
                'data' => [
                    'admission'     => new AdmissionResource($admission),
                    'purpose'       => $purpose,
                    'purposeText'   => "টাকা জমার রশিদ",
                    'date'          => $this->getHijriDate(),
                    'fees'          => $fees,
                    'parentPayment' => [],
                    'paidPayments'  => [],
                    'req_purposes'  => request()->purposes,
                ],
            ]);
        }

        $purpose = request()->purpose ?? null;

        $purpose_array = in_array($purpose, array_keys($purposes)) ? $purposes[$purpose] : "";
        
        $purpose_text = $purpose_array["title"] ?? "";

        $period = $purpose_array["period"] ?? null;
        
        if($admission && $purpose) {
            return Inertia::render('Payment/Create', [
                'data' => [
                    'admission'     => new AdmissionResource($admission),
                    'purpose'       => $purpose,
                    'purposeText'   => $purpose_text,
                    'date'          => $this->getHijriDate(),
                    'fees'          => $this->getAvailableFee($admission, $period, $purpose),
                    'parentPayment' => $this->parentPayment($admission, $purpose),
                    'paidPayments'  => $this->getPaidPayment($admission, $purpose),
                ],
            ]);
        }

        // return
        $admissions = Admission::query()
            ->with([
                'student:id,name,status,registration',
                'student.current_admission:id,student_id,class_id,session,status,roll',
            ])
            ->current()
            ->student()
            ->get([
                'id',
                'student_id',
                'class_id',
                'session',
                'status',
                'roll',
            ]);

        // return
        $classes = Classes::query()
            ->get([
                'id',
                'name',
            ]);

        // return $purposes;

        return Inertia::render('Payment/New', [
            'data' => [
                'admissions'    => $admissions,
                'classes'       => $classes,
                'periods'       => $periods,
                'purposes'      => $purposes,
                'purposeId'     => request()->purpose ?? '',
                'registration'  => request()->registration ?? '',
            ],
        ]);
    }

    protected function getAvailableTotalAmount($admission, $period, $purpose_id = null)
    {
        $total = 0;

        $fees = $this->getAvailableFee($admission, $period, $purpose_id) ?? [];

        foreach($fees as $fee) {
            if(is_array($fee)) {
                $total += ($fee['amount'] ?? 0);
            } else {
                $total += ($fee->amount ?? 0);
            }
        }
        
        return $total;
    }

    protected function getAvailableFee($admission, $period, $purpose_id = null)
    {
        ClassFeeResource::withoutWrapping();

        if($period == 3) {
            $purpose_fee = PurposeFee::query()
                ->with('purpose:id,title')
                ->where([
                    'class_id'      => $admission->class_id,
                    'purpose_id'    => $purpose_id,
                ])
                ->first();

            $concessions = collect(json_decode($admission->concessions, true));

            $concession = $concessions->where('id', $purpose_fee->purpose->id)->first();

            $concession_amount = $concession ? $concession['amount'] : 0;

            $final_amount = $purpose_fee->amount - $concession_amount;

            return [
                [
                    'id'            => (int) 0,
                    'classId'       => (int) ($admission->class_id ?? 0),
                    'feeId'         => (int) ($purpose_fee->purpose->id ?? 0),
                    'package'       => [1, 2, 3, 4],
                    'amount'        => (double) ($final_amount > 0 ? $final_amount : 0),
                    'concession'    => (double) ($concession_amount ?? 0),
                    'name'          => (string) ($purpose_fee->purpose->title ?? ''),
                    'period'        => (int) 3,
                ]
            ];
        }

        $resident = $admission->student->resident ?? 0;
        $resident = in_array($resident, [1, 2, 3, 4]) ? $resident : 0;

        $class_fees = ClassFee::query()
            ->with('fee')
            ->where('class_id', $admission->class_id)
            ->whereHas('fee', function($query) use ($period) {
                $query->where('period', $period);
            })
            ->get();

        if($resident) {
            $class_fees = $class_fees->filter(function ($class_fee) use ($resident) {
                return in_array($resident, json_decode($class_fee->package));
            });
        }

        $concessions = collect(json_decode($admission->concessions, true));

        foreach($class_fees as $class_fee) {
            $concession = $concessions->where('id', $class_fee->fee_id)->first();

            $concession_amount = $concession ? $concession['amount'] : 0;

            $final_amount = $class_fee->amount - $concession_amount;

            $class_fee->amount = $final_amount > 0 ? $final_amount : 0;

            $class_fee->concession = $concession_amount;
        }

        $class_fees = $class_fees->where('amount', '>', 0);

        return ClassFeeResource::collection($class_fees);
    }

    public function store(Request $request)
    {
        $admission = Admission::query()
            ->with('student')
            ->find($request->admission_id);

        $student_due_purpose_id = $admission->student->due_purpose_id;

        $count_paid_payments = Payment::query()
            ->where([
                "purpose"       => $request->purpose,
                "admission_id"  => $request->admission_id,
            ])
            ->count();

        if($count_paid_payments && $student_due_purpose_id != $request->purpose) {
            return redirect()
                ->route('payments.create', "registration={$admission->student->registration}")
                ->with('status', 'Something Wrong!.');

            return abort(404);
        }

        // return $this->validatedData($request) + [
        //     'due'       => $request->total - $request->paid,
        //     'user_id'   => Auth::id(),
        // ];

        $payment = Payment::create(
            $this->validatedData($request) + [
                'due'       => $request->total - $request->paid,
                'user_id'   => Auth::id(),
            ]
        );

        $this->storePaymentDetail($payment, $request->fees);

        return redirect()
            ->route('payments.show', $payment->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load([
            'admission',
            'payment_details',
        ]);
        
        return Inertia::render('Payment/Show', [
            'data' => [
                'payment' => $this->formatedData($payment)
            ]
        ]);
    }

    public function edit(Payment $payment)
    {
        return Inertia::render('Payment/Edit', [
            'data' => $this->data($payment)
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $payment->update($this->validatedData($request, $payment->id));

        return redirect()
            ->route('payments.show', $payment->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($payment)
    {
        AdmissionResource::withoutWrapping();

        $current_session = $this->getCurrentSession();

        $admissions = Admission::query()
            ->with('class.class_fees')
            ->student()
            ->where('session', $current_session)
            ->get();

        return [
            'payment'       => $this->formatedData($payment),
            'admissions'    => AdmissionResource::collection($admissions),
            'date'      => [
                "value" => "",
                "label" => "",
            ]
        ];
    }

    protected function formatedData($payment)
    {
        PaymentResource::withoutWrapping();

        return new PaymentResource($payment);
    }

    protected function getFilterProperty()
    {
        return [
            'class' => Classes::pluck('name', 'id'),
            // 'student' => Student::pluck('name', 'id'),
            'purpose' => collect(Fee::getPurpose())->map(function($purpose) {
                    return $purpose['title'];
                })->toArray(),
            'other_purpose' => Purpose::pluck('title', 'id'),
        ];
    }

    protected function validatedData($request, $id = '')
    {
        return $request->validate([
            'date' => [
                'required',
                'string',
            ],
            'admission_id' => [
                'required',
                'numeric',
            ],
            // 'purpose' => [
            //     'required',
            //     'numeric',
            //     Rule::unique(Payment::class, 'purpose')
            //         ->where('admission_id', $request->admission_id)
            //         ->where('due', 0)
            //         ->ignore($id),
            // ],
            'purposes' => [],
            'total' => [
                'required',
            ],
            'paid' => [
                'required',
            ],
        ]);
    }

    protected function storePaymentDetail($payment, $collection)
    {
        PaymentDetail::where('payment_id', $payment->id)->delete();

        if(is_array($collection)) {
            foreach($collection as $item) {
                PaymentDetail::onlyTrashed()->updateOrCreate(
                    [
                        "payment_id" => $payment->id,
                    ],
                    [
                        "fee_id"        => $item["feeId"] ?? null,
                        "title"         => $item["name"],
                        "amount"        => $item["amount"],
                        "concession"    => $item["concession"] ?? 0,
                        "deleted_at"    => null,
                    ]
                );
            }
        }

    }

    protected function parentPayment($admission, $purpose)
    {
        PaymentResource::withoutWrapping();

        $payment = Payment::query()
            ->where([
                'admission_id'  => $admission->id,
                'purpose'       => $purpose,
            ])
            ->first();

        return $payment
            ? new PaymentResource($payment)
            : (object) [];
    }

    protected function getPaidPayment($admission, $purpose)
    {
        PaymentResource::withoutWrapping();

        $payments = Payment::query()
            ->where([
                'admission_id'  => $admission->id,
                'purpose'       => $purpose,
            ])
            ->get();

        return $payments
            ? PaymentResource::collection($payments)
            : (object) [];
    }

}
