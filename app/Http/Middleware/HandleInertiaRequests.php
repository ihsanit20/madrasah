<?php

namespace App\Http\Middleware;

use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
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
        

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'request' => $request,
            'settings' => [
                'siteName' => $this->getSettingValueByProperty('site-name'),
                'siteAddress' => $this->getSettingValueByProperty('site-address'),
                'studentAgreement' => $this->getSettingValueByProperty('student-agreement'),
                'guardianAgreement' => $this->getSettingValueByProperty('guardian-agreement'),
            ]
        ]);
    }

    protected function getSettingValueByProperty($property)
    {
        $setting = Setting::property($property)->first();


        return $setting
            ? ($setting->value ?? $setting->dummy) 
            : '';
    }
}
