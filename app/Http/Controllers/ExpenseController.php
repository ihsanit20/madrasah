<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index()
    {
        $collections = Expense::query();

        return Inertia::render('Expense/Index', [
            'data' => [
                'collections'   => ExpenseResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Expense/Create', [
            'data' => $this->data(new Expense())
        ]);
    }

    public function store(Request $request)
    {
        $expense = Expense::create($this->validatedData($request));

        return redirect()
            ->route('expenses.show', $expense->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Expense $expense)
    {
        return Inertia::render('Expense/Show', [
            'data' => [
                'expense' => $this->formatedData($expense)
            ]
        ]);
    }

    public function edit(Expense $expense)
    {
        return Inertia::render('Expense/Edit', [
            'data' => $this->data($expense)
        ]);
    }

    public function update(Request $request, Expense $expense)
    {
        $expense->update($this->validatedData($request, $expense->id));

        return redirect()
            ->route('expenses.show', $expense->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($expense)
    {
        return [
            'expense' => $this->formatedData($expense),
        ];
    }

    protected function formatedData($expense)
    {
        ExpenseResource::withoutWrapping();

        return new ExpenseResource($expense);
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