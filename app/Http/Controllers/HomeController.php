<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoticeResource;
use App\Models\Classes;
use App\Models\Notice;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $classes = Classes::get();
        $notices = Notice::query()
            ->whereDate('date', '<=', date('Y-m-d'))
            ->get();

        return Inertia::render('Home/Index', [
            'data' => [
                'classes' => $classes,
                'notices' => NoticeResource::collection($notices),
                'principalMessage' => $this->getSettingProperty('principal-message'),
                'headline' => $this->getSettingProperty('headline'),
                'ourMessage' => $this->getSettingProperty('our-message'),
            ]
        ]);

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}
