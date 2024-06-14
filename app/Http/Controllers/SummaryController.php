<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Classes;
use App\Models\Salary;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SummaryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // return $request;

        $from = $request->from ?? date("Y-m-01");
        $to = $request->to ?? date("Y-m-d");

        // return
        $classes = Classes::query()
            ->with([
                'payments' => function($query) use ($from, $to) {
                    $query
                        ->select(['payments.id', 'payments.paid', 'payments.created_at', 'payments.admission_id'])
                        ->when($from, function($query, $from) {
                            $query->whereDate('payments.created_at', '>=', $from);
                        })
                        ->when($to, function($query, $to) {
                            $query->whereDate('payments.created_at', '<=', $to);
                        });
                }
            ])
            ->get([
                'id',
                'name',
            ]);

        // return
        $categories = Category::query()
            ->with([
                'expenses' => function($query) use ($from, $to) {
                    $query
                        ->select(['id', 'amount', 'category_id', 'date'])
                        // ->where('session', $this->getCurrentSession())
                        ->when($from, function($query, $from) {
                            $query->whereDate('date', '>=', $from);
                        })
                        ->when($to, function($query, $to) {
                            $query->whereDate('date', '<=', $to);
                        });
                },
                'incomes' => function($query) use ($from, $to) {
                    $query
                        ->select(['id', 'amount', 'category_id', 'date'])
                        // ->where('session', $this->getCurrentSession())
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
        $incomes = $classes->map(function($class) {
            return [
                "id"    => (int) ($class->id ?? 0),
                "name"  => (string) ($class->name ?? ''),
                "total" => (double) ($class->payments->sum('paid') ?? 0),
            ]; 
        });

        foreach($categories->where('type', 1) as $category) {
            $incomes->push([
                "id"    => (int) ($category->id ?? 0),
                "name"  => (string) ($category->name ?? ''),
                "total" => (double) ($category->incomes->sum('amount') ?? 0),
            ]);
        }
        
        // return $incomes;

        // return 
        $expenses = $categories->where('type', 2)->map(function($category) {
            return [
                "id"    => (int) ($category->id ?? 0),
                "name"  => (string) ($category->name ?? ''),
                "total" => (double) ($category->expenses->sum('amount') ?? 0),
            ]; 
        });


        // return
        $total_salary = Salary::query()
            ->when($from, function($query, $from) {
                $query->whereDate('created_at', '>=', $from);
            })
            ->when($to, function($query, $to) {
                $query->whereDate('created_at', '<=', $to);
            })
            ->sum('paid');

        $expenses->push([
            "id"    => (int) (0),
            "name"  => (string) ("শিক্ষক/স্টাফ বেতন"),
            "total" => (double) ($total_salary ?? 0),
        ]);

        // return $expenses;

        return Inertia::render('Summary/Summary', [
            'data' => [
                'expenses'  => $expenses,
                'incomes'   => $incomes,
                'from'      => $from,
                'to'        => $to,
            ]
        ]);
    }
}
