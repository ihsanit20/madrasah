<?php

namespace App\Http\Controllers;

use App\Http\Resources\SmsServiceResource;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\Guardian;
use App\Models\Purpose;
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
        $is_financial = request()->type === 'financial' ? true : false;

        return Inertia::render('SmsService/Create', [
            'data' => $this->data(new SmsService(), $is_financial)
        ]);
    }

    public function store(Request $request)
    {
        // return $request;

        $sms_service = SmsService::create(
            $this->validatedData($request) + [
                "created_by" => Auth::id(),
                "title" => $request->purpose_id ?? "সাধারণ বার্তা",
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

    public function edit(SmsService $sms_service)
    {
        // return $sms_service;

        $is_financial = $sms_service->title === 'সাধারণ বার্তা' ? false : true;

        return Inertia::render('SmsService/Edit', [
            'data'  => $this->data($sms_service, $is_financial),
            'step'  => 'edit',
        ]);
    }

    public function update(Request $request, SmsService $sms_service)
    {
        // return $sms_service;

        if($request->step === 'edit') {
            $sms_service->update($this->validatedData($request, $sms_service->id));
        }

        if($request->step === 'send') {
            $text = $sms_service->body;

            $comma_separated_numbers = $this->getCommaSeparatedNumbers($sms_service);

            // $to_message_format_json_data = $this->getToMessageFormatJsonData($sms_service);

            $sender_id = $sms_service->sender;

            $this->sendOneToManySms($text, $comma_separated_numbers, $sender_id);

            // $this->sendManyToManySms($to_message_format_json_data, $sender_id);

            $sms_service->update([
                "status" => 2
            ]);
        }

        return redirect()
            ->route('sms-services.show', $sms_service->id)
            ->with('status', 'The sms has been send successfully.');
    }

    public function destroy(SmsService $sms_service)
    {
        // return $sms_service;

        $sms_service
            ->where('status', '!=', 2)
            ->delete();

        return redirect()
            ->route('sms-services.index')
            ->with('status', 'The record has been deleted successfully.');
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

    protected function data($sms, $is_financial = false)
    {
        $data = [];

        $data['sms'] = $this->formatedData($sms);

        $data['senders'] = ["MSZannat", "8809617611021"];

        $data['receivers'] = $this->getReceivers();

        $data['classes'] = Classes::pluck('name', 'id');

        $data['is_financial'] = (boolean) ($is_financial);

        if($is_financial) {
            $purposes = [];

            foreach(Fee::getPurpose() as $purpose_id => $purpose) {
                $purposes[$purpose_id] = [
                    "title" => $purpose["title"],
                ];
            }

            foreach(Purpose::get(['id', 'title']) as $purpose) {
                $purposes[$purpose->id] = [
                    "title" => $purpose->title,
                ];
            }

            // dd($purposes);

            $data["purposes"] = $purposes;
        }

        return $data;
    }

    protected function formatedData($sms)
    {
        SmsServiceResource::withoutWrapping();

        return new SmsServiceResource($sms);
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

        // dd($guardians->toArray());

        $collection_of_receivers = $guardians->map(function ($guardian) {
            return [
                "student_id"            => (int) ($guardian->student->id ?? 0),
                "student_name"          => (string) ($guardian->student->name ?? ""),
                "student_class_id"      => (int) ($guardian->student->current_admission->class_id ?? 0),
                "student_class_roll"    => (int) ($guardian->student->current_admission->roll ?? 0),
                "guardian_name"         => (string) ($guardian->name ?? ""),
                "guardian_phone"        => (string) ($guardian->phone ?? ""),
                "paid_purpose_ids"      => (array) ($guardian->student->payment_purpose ?? []),
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

    protected function sendOneToManySms($text, $numbers, $sender_id = null)
    {
        $url = "http://bulksmsbd.net/api/smsapi";
        $api_key = "aY6OQCp02j2ZAHkgDoLa";
    
        $data = [
            "api_key" => $api_key,
            "senderid" => $sender_id,
            "number" => $numbers,
            "message" => $text
        ];

        // dd($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    protected function sendManyToManySms($json_data, $sender_id = null)
    {
        $url = "http://bulksmsbd.net/api/smsapimany";
        $api_key = "aY6OQCp02j2ZAHkgDoLa";

        $data = [
            "api_key" => $api_key,
            "senderid" => $sender_id,
            "messages" => json_encode($json_data)
        ];

        // dd($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    protected function getCommaSeparatedNumbers($sms_service)
    {
        $number = "";

        foreach($sms_service->receivers as $index => $receiver) {
            if($index) {
                $number .= ",";
            }

            $guardian_number = "88" . substr($receiver["guardian_phone"], -11, 11);

            $number .= $guardian_number;

        }

        return $number;
    }

    protected function getToMessageFormatJsonData($sms_service)
    {
        $data = [];

        foreach($sms_service->receivers as $receiver) {
            $guardian_number = "88" . substr($receiver["guardian_phone"], -11, 11);

            $data[] = [
              "to"      => $guardian_number,
              "message" => $sms_service->body,
            ];
        }

        return $data;
    }
}
