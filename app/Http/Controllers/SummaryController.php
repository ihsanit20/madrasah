<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Classes;
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
        $classes = $classes->map(function($class) {
            return [
                "id"    => $class->id,
                "name"  => $class->name,
                "total" => $class->payments->sum('paid'),
            ]; 
        });

        return Inertia::render('Summary/Summary', [
            'data' => [
                'categories'    => $categories,
                'classes'       => $classes,
                'from'          => $from,
                'to'            => $to,
            ]
        ]);
    }
}
