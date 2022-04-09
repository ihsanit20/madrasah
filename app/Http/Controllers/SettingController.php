<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        $collections = Setting::query();

        return Inertia::render('Setting/Index', [
            'data' => [
                'collections'   => SettingResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Setting/Create', [
            'data' => $this->data(new Setting())
        ]);
    }

    public function store(Request $request)
    {
        $setting = Setting::create($this->validatedData($request));

        return redirect()
            ->route('collections.show', $setting->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Setting $setting)
    {
        return Inertia::render('Setting/Show', [
            'data' => [
                'setting' => $this->formatedData($setting)
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

        return redirect()
            ->route('collections.show', $setting->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()
            ->route('collections.index')
            ->with('status', 'The record has been delete successfully.');
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
            //
        ]);
    }

}