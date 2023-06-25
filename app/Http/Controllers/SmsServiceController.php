<?php

namespace App\Http\Controllers;

use App\Http\Resources\SmsServiceResource;
use App\Models\Classes;
use App\Models\Guardian;
use App\Models\SmsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SmsServiceController extends Controller
{
    public function index()
    {
        $collections = SmsService::query();

        return Inertia::render('SmsService/Index', [
            'data' => [
                'collections'   => SmsServiceResource::collection($collections->paginate(100)->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('SmsService/Create', [
            'data' => $this->data(new SmsService())
        ]);
    }

    public function store()
    {
        return "store";
    }

    protected function getFilterProperty()
    {
        return [
            //
        ];
    }

    protected function data($fee)
    {
        return [
            'sms'       => $this->formatedData($fee),
            'senders'   => ["MSZannat", "0000000000"],
            'guardians' => $this->getGuardianData(),
        ];
    }

    protected function formatedData($fee)
    {
        SmsServiceResource::withoutWrapping();

        return new SmsServiceResource($fee);
    }

    protected function getGuardianData()
    {
        $guardians = Guardian::query()
            ->select([
                'id',
                'name',
                'phone',
            ])
            ->with([
                'student:id,name,guardian_info_id',
                'student.current_admission:id,student_id,class_id',
            ])
            ->has('student.current_admission')
            ->get();

        $maping_data_of_guardians = $guardians->map(function ($guardian) {
            return [
                "student_name"      => (string) ($guardian->student->name ?? ""),
                "student_class_id"  => (int) ($guardian->student->current_admission->class_id ?? ""),
                "guardian_name"     => (string) ($guardian->name ?? ""),
                "guardian_phone"    => (string) ($guardian->phone ?? ""),
            ];
        });

        // dd($maping_data_of_guardians->toArray());

        return $maping_data_of_guardians;
    }
}
