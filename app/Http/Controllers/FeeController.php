<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeeResource;
use App\Models\Fee;
use App\Models\HijriMonth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class FeeController extends Controller
{
    public function index()
    {
        $collections = Fee::query();

        return Inertia::render('Fee/Index', [
            'data' => [
                'collections'   => FeeResource::collection($collections->paginate(100)->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Fee/Create', [
            'data' => $this->data(new Fee())
        ]);
    }

    public function store(Request $request)
    {
        $fee = Fee::create($this->validatedData($request));

        return redirect()
            ->route('fees.index')
            ->with('status', 'The record has been added successfully.');

        return redirect()
            ->route('fees.show', $fee->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Fee $fee)
    {
        return Inertia::render('Fee/Show', [
            'data' => [
                'fee' => $this->formatedData($fee)
            ]
        ]);
    }

    public function edit(Fee $fee)
    {
        return Inertia::render('Fee/Edit', [
            'data' => $this->data($fee)
        ]);
    }

    public function update(Request $request, Fee $fee)
    {
        $fee->update($this->validatedData($request, $fee->id));

        return redirect()
            ->route('fees.index')
            ->with('status', 'The record has been update successfully.');

        return redirect()
            ->route('fees.show', $fee->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();

        return redirect()
            ->route('fees.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($fee)
    {
        return [
            'fee' => $this->formatedData($fee),
            'periods' => Fee::getPeriod(),
            'months' => HijriMonth::get(),
        ];
    }

    protected function formatedData($fee)
    {
        FeeResource::withoutWrapping();

        return new FeeResource($fee);
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
                Rule::unique(Fee::class, 'name')
                    ->where('period', $request->period)
                    ->whereNull('deleted_at')
                    ->ignore($id),
            ],
            'period' => [
                'required',
                'numeric',
            ],
            // 'months' => [],
        ]);
    }

}