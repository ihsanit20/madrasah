<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $classes = Classes::get();

        return Inertia::render('Home/Index', [
            'data' => [
                'classes' => $classes,
                'principalMessage' => Setting::property('principal-message')->first()->value,
                'ourMessage' => Setting::property('our-message')->first()->value,
            ]
        ]);

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}
