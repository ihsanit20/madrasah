<?php

namespace App\Http\Controllers;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Resources\SettingResource;
use App\Models\HijriMonth;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

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

        $date_array = explode("-", $date);

        if(strlen($date_array[2]) == 4) {
            $date_array = array_reverse($date_array);
        }

        $date = implode("-", $date_array);

        $day = Hijri::Date("d", $date);
        $month = Hijri::Date("m", $date);
        $year = Hijri::Date("Y", $date);

        $month = HijriMonth::find($month)->bengali ?? $month;
        
        return "{$day} - {$month} - {$year}";
    }

    public function imageUploadGetLink()
    {
        // return $request;

        $image_path = "";
        $model_instance = "";
        $width = request()->width ?? 300;
        $height = request()->height ?? 300;

        $type = (int) (request()->type ?? 1);

        if (request()->hasFile('image')) {
            $image = request()->file('image');

            $extention = $image->getClientOriginalExtension();

            $fileName = Str::random(10) . time() . '.' . $extention;

            $path = 'image/';

            $finalImage = ImageManagerStatic::make($image);

            $finalImage = $finalImage->fit($width, $height);

            $finalImage = $finalImage->encode($extention);

            Storage::put('public/' . $path . $fileName, $finalImage->__toString());

            $image_path = 'storage/' . $path . $fileName;
        }
        
        if(request()->option == 'student') {
            $model_instance = Student::find(request()->id);
        }
        
        if(request()->option == 'staff') {
            $model_instance = Staff::find(request()->id);
        }

        if($model_instance && $image_path) {
            $this->imageUpdateOrCreate($model_instance, $image_path, $type);
        }

        return $image_path;
    }

    protected function imageUpdateOrCreate($model_instance, $image_path, $type = 1)
    {
        $model_instance = $model_instance->image()->updateOrCreate(
            [
                'type'      => $type,
            ],
            [
                'url'       => "/" . $image_path,
                'user_id'   => Auth::id(),
            ]
        );

        // if($type == 1) {
        //     if($model_instance->image && $model_instance->image->url) {
        //         Storage::delete(str_replace("storage", "public", $model_instance->image->url));
        //     }
        // }

        // if($type == 2) {
        //     if($model_instance->signature && $model_instance->signature->url) {
        //         Storage::delete(str_replace("storage", "public", $model_instance->signature->url));
        //     }
        // }
    }

    public function callArtisan($password, $command, $parameters = []) {
        if($password === 'msi313@mszannat') {
            Artisan::call($command, $parameters);
        }
    }
}
