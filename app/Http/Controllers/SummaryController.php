<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $categories = Category::query()
            ->with([
                'expenses' => function($query) {
                    $query
                        ->select(['id', 'amount', 'category_id', 'date'])
                        ->where('session', $this->getCurrentSession());
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
                'categories' => $categories,
            ]
        ]);
    }
}
