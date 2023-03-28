<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $collections = Category::query()
            ->type(request()->type);

        return Inertia::render('Category/Index', [
            'data' => [
                'collections'   => CategoryResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Category/Create', [
            'data' => $this->data(new Category(), request()->type)
        ]);
    }

    public function store(Request $request)
    {
        $category = Category::create($this->validatedData($request));

        return redirect()
            ->route('categories.index', [
                'type' => $category->type
            ])
            ->with('status', 'The record has been added successfully.');

        return redirect()
            ->route('categories.show', $category->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Category $category)
    {
        return Inertia::render('Category/Show', [
            'data' => [
                'category' => $this->formatedData($category)
            ]
        ]);
    }

    public function edit(Category $category)
    {
        if(request()->type != $category->type) {
            abort(404);
        }

        return Inertia::render('Category/Edit', [
            'data' => $this->data($category, $category->type)
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validatedData($request, $category->id));

        return redirect()
            ->route('categories.index', [
                'type' => $category->type
            ])
            ->with('status', 'The record has been update successfully.');

        return redirect()
            ->route('categories.show', [
                $category->id,
                'type' => $category->type
            ])
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index', [
                'type' => $category->type
            ])
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($category, int $type)
    {
        return [
            'category'  => $this->formatedData($category),
            'type'      => $type
        ];
    }

    protected function formatedData($category)
    {
        CategoryResource::withoutWrapping();

        return new CategoryResource($category);
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
            ],
            'type' => [
                'required',
                'numeric',
            ]
        ]);
    }

}