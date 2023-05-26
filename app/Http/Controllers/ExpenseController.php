<?php

namespace App\Http\Controllers;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\StaffResource;
use App\Models\Category;
use App\Models\Expense;
use App\Models\HijriMonth;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index()
    {
        $collections = Expense::query()
            ->latest('id');

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
        $expense = Expense::create($this->validatedData($request) + [
            'user_id' => Auth::id(),
            'session' => $this->getCurrentSession(),
        ]);

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

    public function summary(Request $request)
    {
        // return $request;

        $from = $request->from ?? date("Y-m-01");
        $to = $request->to ?? date("Y-m-d");

        $categories = Category::query()
            ->with([
                'expenses' => function($query) use ($from, $to) {
                    $query
                        ->select(['id', 'amount', 'category_id', 'date'])
                        ->where('session', $this->getCurrentSession())
                        ->when($from, function($query, $from) {
                            $query->whereDate('date', '>=', $from);
                        })
                        ->when($to, function($query, $to) {
                            $query->whereDate('date', '<=', $to);
                        });
                }
            ])
            ->get();

        // return 
        $categories = $categories->map(function($category) {
            return [
                "id"    => $category->id,
                "name"  => $category->name,
                "total" => $category->expenses->sum('amount'),
            ]; 
        });

        return Inertia::render('Expense/Summary', [
            'data' => [
                'categories'    => $categories,
                'from'          => $from,
                'to'            => $to,
            ]
        ]);
    }

    public function monthsIndex()
    {
        $expenses = Expense::query()
            ->where('session', $this->getCurrentSession())
            ->get([
                'id',
                'date',
                'amount'
            ]);

        $expenses->map(function (&$expense) {
            $expense->hijri_month = $this->getHijriMonth($expense->date);
        });

        $expenses_groups = $expenses->groupBy('hijri_month');

        $index = 0;

        foreach($expenses_groups as $month_id => $expenses) {
            $months[$index] = HijriMonth::find($month_id, ['id', 'bengali']);
            $months[$index]->expenses_count = $expenses->count();
            $months[$index]->total_amount = $expenses->sum('amount');
            $index++;
        }

        // return $months;
        
        return Inertia::render('Expense/Month/Index', [
            'data' => [
                'months' => $months,
            ]
        ]);
    }

    public function monthsShow(HijriMonth $month)
    {
        $expenses = Expense::query()
            ->where('session', $this->getCurrentSession())
            ->get([
                'id',
                'date',
            ]);

        $expenses->map(function (&$expense) {
            $expense->hijri_month = $this->getHijriMonth($expense->date);
        });

        $expense_ids = $expenses->where('hijri_month', $month->id)->pluck('id');

        $collections = Expense::query()
            ->whereIn('id', $expense_ids)
            ->latest('id');

        return Inertia::render('Expense/Index', [
            'data' => [
                'collections'   => ExpenseResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function monthsCategoriesIndex(HijriMonth $month)
    {
        $expenses = Expense::query()
            ->where('session', $this->getCurrentSession())
            ->get([
                'id',
                'date',
                'category_id'
            ]);

        $expenses->map(function (&$expense) {
            $expense->hijri_month = $this->getHijriMonth($expense->date);
        });

        $category_ids = $expenses->where('hijri_month', $month->id)->pluck('category_id');


        $categories = Category::query()
            ->with('expenses:id,category_id,amount')
            ->withCount('expenses')
            ->whereIn('id', $category_ids)
            ->get();

        $categories->map(function(&$category) {
            $category->total_amount = $category->expenses->sum('amount');
        });

        return Inertia::render('Expense/Month/Show', [
            'data' => [
                'categories' => $categories,
                'month'      => $month,
            ]
        ]);
    }

    public function categoriesIndex()
    {
        $categories = Category::query()
            ->with('expenses:id,category_id,amount,session')
            ->whereHas('expenses', function($query) {
                $query->where('session', $this->getCurrentSession());
            })
            ->withCount('expenses')
            ->get();

        $categories->map(function(&$category) {
            $category->total_amount = $category->expenses->sum('amount');
        });

        return Inertia::render('Expense/Category/Index', [
            'data' => [
                'categories' => $categories,
            ]
        ]);
    }

    public function categoriesShow(Category $category)
    {
        $collections = Expense::query()
            ->where('category_id', $category->id)
            ->where('session', $this->getCurrentSession())
            ->latest('id');

        return Inertia::render('Expense/Index', [
            'data' => [
                'collections'   => ExpenseResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function CategoriesmonthsIndex(Category $category)
    {
        $expenses = Expense::query()
            ->where('session', $this->getCurrentSession())
            ->where('category_id', $category->id)
            ->get([
                'id',
                'date',
                'amount'
            ]);

        $expenses->map(function (&$expense) {
            $expense->hijri_month = $this->getHijriMonth($expense->date);
        });

        $expenses_groups = $expenses->groupBy('hijri_month');

        $index = 0;

        foreach($expenses_groups as $month_id => $expenses) {
            $months[$index] = HijriMonth::find($month_id, ['id', 'bengali']);
            $months[$index]->expenses_count = $expenses->count();
            $months[$index]->total_amount = $expenses->sum('amount');
            $index++;
        }

        // return $months;
        
        return Inertia::render('Expense/Category/Show', [
            'data' => [
                'months'    => $months,
                'category'  => $category,
            ]
        ]);
    }

    protected function data($expense)
    {
        CategoryResource::withoutWrapping();
        StaffResource::withoutWrapping();

        return [
            'expense'       => $this->formatedData($expense),
            'staff'         => StaffResource::collection(Staff::get()),
            'categories'    => CategoryResource::collection(Category::type(2)->orderBy('name')->get()),
            'hijriMonths'   => HijriMonth::get(),
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
            'category_id' => [
                'required',
                // Rule::unique(Expense::class, 'category_id')
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