<?php

namespace App\Http\Controllers;

use App\Http\Resources\DesignationResource;
use App\Http\Resources\SalaryResource;
use App\Http\Resources\StaffResource;
use App\Models\Appointment;
use App\Models\Staff;
use App\Models\Salary;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalaryController extends Controller
{
    public function index()
    {
        $collections = Salary::query()
            ->with('staff:id,name')
            ->latest()
            ->search(['id'])
            ->filter(request())
            ->latest('id');

        // return SalaryResource::collection($collections->paginate(request()->perpage)->appends(request()->input()));

        return Inertia::render('Staff/Salary/Index', [
            'data' => [
                'collections'  => SalaryResource::collection($collections->paginate(request()->perpage)->appends(request()->input())),
                'filters'   => $this->getFilterProperty(),
            ]
        ]);
    }

    public function show(Salary $salary)
    {
        // return
        $salary->load([
            'staff:id,name',
            'staff.current_appointment:id,staff_id,session,designation_id',
            'staff.current_appointment.designation:id,name',
        ]);

        return Inertia::render('Staff/Salary/Show', compact('salary'));
    }

    public function create(Staff $staff)
    {
        // return
        $staff->load([
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
                'session'       => Salary::$current_session,  
            ] + $this->validatedData($request)
        );

        return redirect()
            ->route('staff.show', $staff->id)
            ->with('status', 'The record has been update successfully.');
    }

    protected function save($request, $staff)
    {
        return "Under Maintenance";
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
            'purposes' => array_slice(Salary::getPurpose(), -24, 24, true),
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
            'purpose'   => Salary::getPurpose(),
            'staff'     => Staff::pluck('name', 'id'),
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
