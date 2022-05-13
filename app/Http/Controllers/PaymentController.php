<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdmissionResource;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\ClassFeeResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\StudentResource;
use App\Models\Admission;
use App\Models\Classes;
use App\Models\ClassFee;
use App\Models\Fee;
use App\Models\HijriMonth;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index($period = null)
    {
        $collections = Payment::query()
            ->with('admission')
            ->period($period);

        return Inertia::render('Payment/Index', [
            'data' => [
                'collections'   => PaymentResource::collection($collections->paginate()->appends(request()->input())),
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
        AdmissionResource::withoutWrapping();
        ClassesResource::withoutWrapping();

        $periods = Fee::getPeriod();

        $period = request()->period ?? null;

        $periodText = in_array($period, array_keys($periods)) ? $periods[$period] : "";

        $admission = Admission::query()
            ->with('student')
            ->current()
            ->student()
            ->find(request()->admission);
        
        if($admission && $periodText) {
            return Inertia::render('Payment/Create', [
                'data' => [
                    'admission'     => new AdmissionResource($admission),
                    'period'        => $period,
                    'periodText'    => $periodText,
                    'date'          => $this->getHijriDate(),
                    'fees'          => $this->getAvailableFee($admission, $period),
                ],
            ]);
        }

        $admissions = Admission::query()
            ->current()
            ->student()
            ->get();

        $classes = Classes::query()
            ->get();

        return Inertia::render('Payment/New', [
            'data' => [
                'admissions'    => AdmissionResource::collection($admissions),
                'classes'       => ClassesResource::collection($classes),
                'periods'       => $periods,
            ],
        ]);
    }

    protected function getAvailableFee($admission, $period)
    {
        ClassFeeResource::withoutWrapping();

        $resident = $admission->student->resident ?? 0;
        $resident = in_array($resident, [1, 2, 3, 4]) ? $resident : 0;

        $class_fees = ClassFee::query()
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
        }

        $class_fees = $class_fees->where('amount', '>', 0);

        return ClassFeeResource::collection($class_fees);
    }

    public function store(Request $request)
    {
        return $request;

        $payment = Payment::create(
            $this->validatedData($request) + [
                'due' => $request->total - $request->paid
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
            //
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
            'period' => [
                'required',
                'numeric',
            ],
            'total' => [
                'required',
            ],
            'paid' => [],
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
                        "title"         => $item["title"],
                        "amount"        => $item["amount"],
                        "deleted_at"    => null,
                    ]
                );
            }
        }

    }

}