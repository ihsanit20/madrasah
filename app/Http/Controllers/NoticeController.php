<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoticeResource;
use App\Http\Resources\StaffResource;
use App\Models\Notice;
use App\Models\Staff;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NoticeController extends Controller
{
    public function index()
    {
        $collections = Notice::query();

        return Inertia::render('Notice/Index', [
            'data' => [
                'collections'   => NoticeResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Notice/Create', [
            'data' => $this->data(new Notice())
        ]);
    }

    public function store(Request $request)
    {
        $notice = Notice::create($this->validatedData($request));

        return redirect()
            ->route('notices.show', $notice->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Notice $notice)
    {
        return Inertia::render('Notice/Show', [
            'data' => [
                'notice' => $this->formatedData($notice)
            ]
        ]);
    }

    public function edit(Notice $notice)
    {
        return Inertia::render('Notice/Edit', [
            'data' => $this->data($notice)
        ]);
    }

    public function update(Request $request, Notice $notice)
    {
        $notice->update($this->validatedData($request, $notice->id));

        return redirect()
            ->route('notices.show', $notice->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();

        return redirect()
            ->route('notices.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($notice)
    {
        StaffResource::withoutWrapping();

        return [
            'notice' => $this->formatedData($notice),
            'staffList' => StaffResource::collection(Staff::get()),
        ];
    }

    protected function formatedData($notice)
    {
        NoticeResource::withoutWrapping();

        return new NoticeResource($notice);
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
            'date'      => 'required',
            'title'     => 'required',
            'body'      => 'required',
            'staff_id'  => 'required',
        ]);
    }

}