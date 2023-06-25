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
            'classes'   => Classes::pluck('name', 'id'),
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
                'student.current_admission:id,student_id,class_id,roll',
            ])
            ->has('student.current_admission')
            ->get();

        $maping_data_of_guardians = $guardians->map(function ($guardian) {
            return [
                "student_id"            => (int) ($guardian->student->id ?? 0),
                "student_name"          => (string) ($guardian->student->name ?? ""),
                "student_class_id"      => (int) ($guardian->student->current_admission->class_id ?? 0),
                "student_class_roll"    => (int) ($guardian->student->current_admission->roll ?? 0),
                "guardian_name"         => (string) ($guardian->name ?? ""),
                "guardian_phone"        => (string) ($guardian->phone ?? ""),
            ];
        });

        // dd($maping_data_of_guardians->toArray());

        $array_data_of_guardians = $maping_data_of_guardians->toArray();
        
        usort($array_data_of_guardians, function($a, $b) {
            if(strcmp($a['student_class_id'], $b['student_class_id']) == 0) {
                return strcmp($a['student_class_roll'], $b['student_class_roll']);
            }

            return strcmp($a['student_class_id'], $b['student_class_id']);
        });

        return $array_data_of_guardians;
    }
}
