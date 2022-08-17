<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassesResource;
use App\Models\Classes;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdmitCardController extends Controller
{
    public function index()
    {
        $collections = Classes::query()
            ->with('teacher', 'students');

        ClassesResource::withoutWrapping();

        return Inertia::render('AdmitCard/Index', [
            'data' => [
                'classes' => ClassesResource::collection($collections->get()),
            ]
        ]);
    }
}
