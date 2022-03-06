<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdmissionResource;
use App\Models\Admission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdmissionController extends Controller
{
    public function index()
    {
        $collections = Admission::query();

        $collections = $collections
            ->orderBy('year', 'desc')
            ->orderBy('roll');

        return Inertia::render('Admission/Index', [
            'data' => [
                'collections'   => AdmissionResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Admission/Create', [
            'data' => $this->data(new Admission())
        ]);
    }

    public function store(Request $request)
    {
        $admission = Admission::create($this->validatedData($request));

        return redirect()
            ->route('admissions.show', $admission->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Admission $admission)
    {
        return Inertia::render('Admission/Show', [
            'data' => [
                'admission' => $this->formatedData($admission)
            ]
        ]);
    }

    public function edit(Admission $admission)
    {
        return Inertia::render('Admission/Edit', [
            'data' => $this->data($admission)
        ]);
    }

    public function update(Request $request, Admission $admission)
    {
        $admission->update($this->validatedData($request, $admission->id));

        return redirect()
            ->route('admissions.show', $admission->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Admission $admission)
    {
        $admission->delete();

        return redirect()
            ->route('admissions.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($admission)
    {
        return [
            'admission' => $this->formatedData($admission),
        ];
    }

    protected function formatedData($admission)
    {
        AdmissionResource::withoutWrapping();

        return new AdmissionResource($admission);
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