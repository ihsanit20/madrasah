<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index()
    {
        $collections = Payment::query();

        $collections->with(['admission','fees']);

        return PaymentResource::collection($collections->paginate());

        return Inertia::render('Payment/Index', [
            'data' => [
                'collections'   => PaymentResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Payment/Create', [
            'data' => $this->data(new Payment())
        ]);
    }

    public function store(Request $request)
    {
        $payment = Payment::create($this->validatedData($request));

        return redirect()
            ->route('collections.show', $payment->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Payment $payment)
    {
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
            ->route('collections.show', $payment->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('collections.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($payment)
    {
        return [
            'payment' => $this->formatedData($payment),
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
            //
        ]);
    }

}