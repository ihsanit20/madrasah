<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getSettingProperty($key)
    {
        SettingResource::withoutWrapping();

        $setting = Setting::query()
            ->property($key)
            ->first();

        if($setting) {
            $setting->value = $setting->value ?? $setting->dummy;
        }

        return new SettingResource($setting);
    }

    protected function getCurrentSession()
    {
        return "43-44";
    }
}
