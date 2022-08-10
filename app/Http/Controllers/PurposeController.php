<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PurposeResource;
use App\Models\Classes;
use App\Models\Purpose;
use App\Models\PurposeFee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurposeController extends Controller
{
    public function index()
    {
        $collections = Purpose::query();

        return Inertia::render('Purpose/Index', [
            'data' => [
                'collections'   => PurposeResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Purpose/Create', [
            'data' => $this->data(new Purpose())
        ]);
    }

    public function store(Request $request)
    {
        $purpose = Purpose::create($this->validatedData($request));

        $this->storePurposeFee($request->purpose_fees, $purpose->id);

        return redirect()
            ->route('purposes.show', $purpose->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Purpose $purpose)
    {
        $purpose->load('purpose_fees.class');

        return Inertia::render('Purpose/Show', [
            'data' => [
                'purpose' => $this->formatedData($purpose)
            ]
        ]);
    }

    public function edit(Purpose $purpose)
    {
        return Inertia::render('Purpose/Edit', [
            'data' => $this->data($purpose)
        ]);
    }

    public function update(Request $request, Purpose $purpose)
    {
        $purpose->update($this->validatedData($request, $purpose->id));

        return redirect()
            ->route('purposes.show', $purpose->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Purpose $purpose)
    {
        $purpose->delete();

        return redirect()
            ->route('purposes.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($purpose)
    {
        return [
            'purpose' => $this->formatedData($purpose),
            'classes' => Classes::get(),  
        ];
    }

    protected function formatedData($purpose)
    {
        PurposeResource::withoutWrapping();

        return new PurposeResource($purpose);
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
            'title' => 'required|string',
        ]);
    }

    protected function storePurposeFee($purpose_fees, $purpose_id)
    {
        PurposeFee::where('purpose_id', $purpose_id)->delete();

        if(is_array($purpose_fees)) {
            foreach($purpose_fees as $purpose_fee) {
                if($purpose_fee["amount"]) {
                    PurposeFee::onlyTrashed()
                        ->updateOrCreate(
                            [],
                            [
                                "purpose_id"    => $purpose_id,
                                "class_id"      => $purpose_fee["class_id"],
                                "amount"        => $purpose_fee["amount"],
                                "deleted_at"    => null
                            ]
                        );
                }
            }
        }
    }

}