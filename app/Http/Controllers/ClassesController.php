<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\FeeResource;
use App\Http\Resources\StaffResource;
use App\Models\Classes;
use App\Models\ClassFee;
use App\Models\Fee;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ClassesController extends Controller
{
    public function index()
    {
        $collections = Classes::query()
            ->with('class_fees');

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
                'packages'  => Student::getResidentArrayData(),
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
        StaffResource::withoutWrapping();
        FeeResource::withoutWrapping();

        return [
            'classes'   => $this->formatedData($class),
            'fees'      => FeeResource::collection(Fee::get()),
            'staffList' => StaffResource::collection(Staff::get()),
            'packages'  => Student::getResidentArrayData(),
        ];
    }

    protected function formatedData($class)
    {
        ClassesResource::withoutWrapping();

        return new ClassesResource($class->load(
            'subjects',
            'class_fees.fee',
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
            'staff_id' => '',
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
        ClassFee::where('class_id', $class_id)->delete();

        if(!is_array($fees)) {
            return;
        }

        foreach($fees as $fee) {
            if($fee['checked']) {
                ClassFee::onlyTrashed()->updateOrCreate(
                    [
                        'class_id'      => $class_id,
                    ],
                    [
                        'fee_id'        => $fee['id'],
                        'amount'        => $fee['amount'],
                        'package'       => json_encode($fee['package']),
                        'deleted_at'    => NULL,
                    ]
                );
            }
        }

        return ClassFee::where('class_id', $class_id)->get();
    }

}