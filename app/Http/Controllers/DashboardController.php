<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // return auth()->user()->roles->isEmpty();
        $logo = Setting::where('key', 'logo')->first();
        return view('dashboard.index', compact('logo'));
    }
}
