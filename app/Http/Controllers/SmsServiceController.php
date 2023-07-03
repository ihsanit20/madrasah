<?php

namespace App\Http\Controllers;

use App\Http\Resources\SmsServiceResource;
use App\Models\Classes;
use App\Models\Guardian;
use App\Models\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function store(Request $request)
    {
        return $request;

        $sms_service = SmsService::create(
            $this->validatedData($request) + [
                "created_by" => Auth::id(),
            ]
        );

        return redirect()
            ->route('sms-services.show', $sms_service->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(SmsService $sms_service)
    {
        // return $sms_service;

        return Inertia::render('SmsService/Show', [
            'data' => [
                'sms_service' => $this->formatedData($sms_service)
            ]
        ]);
    }
    
    protected function validatedData($request, $id = '')
    {
        return $request->validate([
            'title' => [],
            'body' => ['required'],
            'sender' => ['required'],
            'receivers' => ['required', 'array'],
        ]);
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
            'receivers' => $this->getReceivers(),
            'classes'   => Classes::pluck('name', 'id'),
        ];
    }

    protected function formatedData($fee)
    {
        SmsServiceResource::withoutWrapping();

        return new SmsServiceResource($fee);
    }

    protected function getReceivers()
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

        $collection_of_receivers = $guardians->map(function ($guardian) {
            return [
                "student_id"            => (int) ($guardian->student->id ?? 0),
                "student_name"          => (string) ($guardian->student->name ?? ""),
                "student_class_id"      => (int) ($guardian->student->current_admission->class_id ?? 0),
                "student_class_roll"    => (int) ($guardian->student->current_admission->roll ?? 0),
                "guardian_name"         => (string) ($guardian->name ?? ""),
                "guardian_phone"        => (string) ($guardian->phone ?? ""),
            ];
        });

        // dd($collection_of_receivers->toArray());

        $array_of_receivers = $collection_of_receivers->toArray();
        
        usort($array_of_receivers, function($a, $b) {
            if(strcmp($a['student_class_id'], $b['student_class_id']) == 0) {
                return strcmp($a['student_class_roll'], $b['student_class_roll']);
            }

            return strcmp($a['student_class_id'], $b['student_class_id']);
        });

        return $array_of_receivers;
    }
}
