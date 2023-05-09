<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\AcademicSession;
use App\Models\Admission;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Expense;
use App\Models\Fee;
use App\Models\Income;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    const DYNAMIC_ACADEMIC_SESSION_ABLE_MODELS = [
        Classes::class,
        Student::class,
        Admission::class,
        Expense::class,
        Income::class,
        Payment::class,
        Exam::class,
        Fee::class,
    ];

    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $settings = Setting::get();

        if($request->session) {
            Auth::user()->update(['active_academic_session' => $request->session]);
        }

        $active_academic_session = Auth::user()->active_academic_session ?? "44-45";

        $current_academic_session = AcademicSession::query()
            ->where('value', $active_academic_session)
            ->latest("id")
            ->first();

        if(!$current_academic_session) {
            $current_academic_session = AcademicSession::query()
                ->latest("id")
                ->first();
        }

        $previous_academic_session = AcademicSession::query()
            ->where('id', '<', $current_academic_session->id)
            ->latest()
            ->first();

        // Set current academic session && previous academic session
        $this->setAcademicSession($current_academic_session->value ?? null, $previous_academic_session->value ?? null);

        Controller::$current_academic_session = $current_academic_session->value ?? "";
        Controller::$previous_academic_session = $previous_academic_session->value ?? "";

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'request'   => $request,
            'settings'  => [
                'siteName'          => $this->getSettingValueByProperty($settings, 'site-name'),
                'siteAddress'       => $this->getSettingValueByProperty($settings, 'site-address'),
                'sitePhone'         => $this->getSettingValueByProperty($settings, 'site-phone'),
                'studentAgreement'  => $this->getSettingValueByProperty($settings, 'student-agreement'),
                'guardianAgreement' => $this->getSettingValueByProperty($settings, 'guardian-agreement'),
                'idCardTime'        => $this->getSettingValueByProperty($settings, 'id-card-time'),
                'admitCardText'     => $this->getSettingValueByProperty($settings, 'admit-card-text'),
            ],
            'academic_sessions'     => AcademicSession::query()
                ->latest()
                ->get([
                    'value',
                    'bengali',
                ]),

            'current_academic_session'  => $current_academic_session,
            'previous_academic_session' => $previous_academic_session,
        ]);
    }

    protected function getSettingValueByProperty($settings, $property)
    {
        $setting = $settings->where('key', $property)->first();

        return $setting
            ? ($setting->value ?? $setting->dummy) 
            : '';
    }

    private function setAcademicSession($current_academic_session = null, $previous_academic_session = null)
    {
        foreach(self::DYNAMIC_ACADEMIC_SESSION_ABLE_MODELS as $model) {
            if(isset($model::$current_session)) {
                $model::$current_session = $current_academic_session;
            }

            if(isset($model::$previous_session)) {
                $model::$previous_session = $previous_academic_session;
            }
        }
    }
}