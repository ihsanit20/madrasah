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

    public function new()
    {
        AdmissionResource::withoutWrapping();
        ClassesResource::withoutWrapping();

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
            ],
        ]);
    }

    public function create()
    {
        return $this->data(new Payment());
        return Inertia::render('Payment/Create', [
            'data' => $this->data(new Payment())
        ]);
    }

    public function store(Request $request)
    {
        // return $request;

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