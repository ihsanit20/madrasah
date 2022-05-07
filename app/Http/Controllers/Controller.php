<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingResource;
use App\Models\HijriMonth;
use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

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

    public function getHijriDate($date = null)
    {
        $date = $date ?? date("d-m-Y");

        $response = Http::get("https://api.aladhan.com/v1/gToH?date={$date}");

        $response = $response->object();
        
        $current_weekday = $response->data->gregorian->weekday->en;

        $current_day = $response->data->hijri->day;

        $current_month = $response->data->hijri->month;

        $current_month->bn = HijriMonth::find($current_month->number)->bengali ?? $current_month->en;

        $current_year = $response->data->hijri->year;

        return "{$current_day} $current_month->bn {$current_year}";
    }
}
