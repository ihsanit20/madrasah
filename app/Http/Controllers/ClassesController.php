<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassesResource;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ClassesController extends Controller
{
    public function index()
    {
        $collections = Classes::query();

        return Inertia::render('Classes/Index', [
            'data' => [
                'collections'   => ClassesResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Classes/Create', [
            'data' => $this->data(new Classes())
        ]);
    }

    public function store(Request $request)
    {
        $class = Classes::create($this->validatedData($request));

        $this->storeSubject($class->id, $request->subjects);

        $this->storeFee($class->id, $request->fees);

        return redirect()
            ->route('classes.show', $class->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Classes $class)
    {
        return Inertia::render('Classes/Show', [
            'data' => [
                'classes' => $this->formatedData($class),
            ]
        ]);
    }

    public function edit(Classes $class)
    {
        return Inertia::render('Classes/Edit', [
            'data' => $this->data($class)
        ]);
    }

    public function update(Request $request, Classes $class)
    {
        $class->update($this->validatedData($request, $class->id));
        
        $this->storeSubject($class->id, $request->subjects);

        $this->storeFee($class->id, $request->fees);

        return redirect()
            ->route('classes.show', $class->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Classes $class)
    {
        $class->delete();

        return redirect()
            ->route('classes.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($class)
    {
        return [
            'classes' => $this->formatedData($class),
            'periods' => Fee::getPeriod(),
        ];
    }

    protected function formatedData($class)
    {
        ClassesResource::withoutWrapping();

        return new ClassesResource($class->load(
            'subjects',
            'fees',
        ));
    }

    private function getFilterProperty()
    {
        return [
            //
        ];
    }

    private function validatedData($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique(Classes::class, 'name')->ignore($id),
            ],
            'description' => '',
        ]);
    }
    
    private function storeSubject($class_id, $subjects)
    {
        Subject::where('class_id', $class_id)->delete();

        if(!is_array($subjects)) {
            return;
        }

        foreach($subjects as $subject) {
            Subject::onlyTrashed()->updateOrCreate(
                [
                    'class_id'      => $class_id,
                ],
                [
                    'name'          => $subject['name'],
                    'book'          => $subject['book'],
                    'deleted_at'    => NULL,
                ]
            );
        }
    }
    
    private function storeFee($class_id, $fees)
    {
        Fee::where('class_id', $class_id)->delete();

        if(!is_array($fees)) {
            return;
        }

        foreach($fees as $fee) {
            Fee::onlyTrashed()->updateOrCreate(
                [
                    'class_id'      => $class_id,
                ],
                [
                    'name'          => $fee['name'],
                    'period'        => $fee['period'],
                    'amount'        => $fee['amount'],
                    'deleted_at'    => NULL,
                ]
            );
        }
    }

}