<?php

namespace App\Http\Controllers;

use App\Http\Resources\DesignationResource;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use App\Models\Salary;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalaryController extends Controller
{
    public function create(Staff $staff)
    {
        // return
        $staff->load([
            'designation',
            'salaries'
        ]);

        // return
        $paid_purpose_ids = $staff->salaries->pluck('purpose_id')->toArray();

        // return $this->data($staff);

        return Inertia::render('Staff/Salary/Create', [
            'data' => $this->data($staff),
            'paid_purpose_ids' => $paid_purpose_ids,
        ]);
    }

    public function store(Request $request, Staff $staff)
    {
        // return $request;
        $staff_payment = Salary::Create(
            [
                'staff_id'      => $staff->id,
                'purpose_id'    => $request->purpose_id,
            ] + $this->validatedData($request)
        );

        return redirect()
            ->route('staff.show', $staff->id)
            ->with('status', 'The record has been update successfully.');
    }

    protected function save($request, $staff)
    {
        return Salary::withTrashed()->updateOrCreate(
            [
                'staff_id'      => $staff->id,
                'purpose_id'    => $request->purpose_id,
            ],
            $this->validatedData($request)
        );
    }

    protected function data($staff)
    {
        DesignationResource::withoutWrapping();

        return [
            'staff' => $this->formatedData($staff),
            'purposes' => Salary::getPurpose(),
        ];
    }

    protected function formatedData($staff)
    {
        StaffResource::withoutWrapping();

        return new StaffResource($staff);
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
            'salaries' => [
                'required',
                'array',
            ],
            'purpose_id' => [
                'required',
                'numeric',
            ],
            'total' => [
                'required',
            ],
            'paid' => [
                'required',
            ],
            'cut' => [],
            'due' => [],
        ]);
    }
}
