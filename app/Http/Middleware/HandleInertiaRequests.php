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
        $settings = Setting::get();

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'request' => $request,
            'settings' => [
                'siteName' => $this->getSettingValueByProperty($settings, 'site-name'),
                'siteAddress' => $this->getSettingValueByProperty($settings, 'site-address'),
                'studentAgreement' => $this->getSettingValueByProperty($settings, 'student-agreement'),
                'guardianAgreement' => $this->getSettingValueByProperty($settings, 'guardian-agreement'),
            ]
        ]);
    }

    protected function getSettingValueByProperty($settings, $property)
    {
        $setting = $settings->where('key', $property)->first();

        return $setting
            ? ($setting->value ?? $setting->dummy) 
            : '';
    }
}
