<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function siteSetup()
    {
        return $this->index($this->getTypeByText(request()->segment(2)));
    }

    public function homePage()
    {
        return $this->index($this->getTypeByText(request()->segment(2)));
    }

    protected function getTypeByText($value)
    {
        switch($value) {
            case 'site-setup':
                return 1;
            case 'home-page':
                return 2;
        }
    }

    protected function getRouteName($type)
    {
        switch($type) {
            case 1:
                return 'settings.site-setup';
            case 2:
                return 'settings.home-page';
        }
    }

    protected function getPageTitle($type)
    {
        switch($type) {
            case 1:
                return 'সাইট সেটিং';
            case 2:
                return 'হোমপেজ সেটিং';
        }
    }

    public function index($type)
    {
        $collections = Setting::query()
            ->orderBy('priority')
            ->type($type);

        // dd($collections->paginate());

        return Inertia::render('Setting/Index', [
            'data' => [
                'collections'   => SettingResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
                'pageTitle'     => $this->getPageTitle($type)
            ]
        ]);
    }

    public function edit(Setting $setting)
    {
        return Inertia::render('Setting/Edit', [
            'data' => $this->data($setting)
        ]);
    }

    public function update(Request $request, Setting $setting)
    {
        $setting->update($this->validatedData($request, $setting->id));

        $this->removeCache();

        return redirect()
            ->route($this->getRouteName($setting->type))
            ->with('status', 'The record has been update successfully.');
    }

    protected function data($setting)
    {
        return [
            'setting' => $this->formatedData($setting),
        ];
    }

    protected function formatedData($setting)
    {
        SettingResource::withoutWrapping();

        return new SettingResource($setting);
    }

    protected function getFilterProperty()
    {
        return [
            //
        ];
    }

    protected function validatedData($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
            ],
            'value' => '',
        ]);
    }

    protected function removeCache()
    {
        Cache::forget(Setting::ALL_SETTING_DATA_CACHE_KEY);
    }

}