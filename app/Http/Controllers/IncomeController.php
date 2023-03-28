<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\IncomeResource;
use App\Http\Resources\StaffResource;
use App\Models\Category;
use App\Models\HijriMonth;
use App\Models\Income;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IncomeController extends Controller
{
    public function index()
    {
        $collections = Income::query()
            ->latest('id');

        return Inertia::render('Income/Index', [
            'data' => [
                'collections'   => IncomeResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Income/Create', [
            'data' => $this->data(new Income())
        ]);
    }

    public function store(Request $request)
    {
        $income = Income::create($this->validatedData($request) + [
            'user_id' => Auth::id(),
            'session' => $this->getCurrentSession(),
        ]);

        return redirect()
            ->route('incomes.show', $income->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Income $income)
    {
        return Inertia::render('Income/Show', [
            'data' => [
                'income' => $this->formatedData($income)
            ]
        ]);
    }

    public function edit(Income $income)
    {
        return Inertia::render('Income/Edit', [
            'data' => $this->data($income)
        ]);
    }

    public function update(Request $request, Income $income)
    {
        $income->update($this->validatedData($request, $income->id));

        return redirect()
            ->route('incomes.show', $income->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()
            ->route('incomes.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($income)
    {
        CategoryResource::withoutWrapping();
        StaffResource::withoutWrapping();

        return [
            'income'        => $this->formatedData($income),
            'staff'         => StaffResource::collection(Staff::orderBy('designation_id')->get()),
            'categories'    => CategoryResource::collection(Category::type(1)->orderBy('name')->get()),
            'hijriMonths'   => HijriMonth::get(),
        ];
    }

    protected function formatedData($income)
    {
        IncomeResource::withoutWrapping();

        return new IncomeResource($income);
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
            'category_id' => [
                'required',
                // Rule::unique(Income::class, 'category_id')
                //     ->whereNull('date', $request->date)
                //     ->whereNull('deleted_at')
                //     ->ignore($id)
            ],
            'staff_id' => [
                'required',
            ],
            'amount' => [
                'required',
            ],
            'date' => [
                'required',
            ],
            'description' => [
                'required',
            ],
        ]);
    }

}