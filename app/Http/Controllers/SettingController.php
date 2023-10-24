<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function change_logo(Request $request)
    {
        try {
            //code...
            $imagePath = 'public/media';
            if ($file = $request->file('logo')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'logo_' . md5(time()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                // $data['logo'] = $name;
            }
            $setting = Setting::updateOrCreate(
                ['key' => 'logo'],
                ['label' => 'Site Logo', 'value' => $name]
            );
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Storage::delete('/public/media/' . $name);
            return back()->with('error', 'Error: Something went wrong!');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreSettingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Setting $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateSettingRequest $request
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $setting = Setting::where('key', 'logo')->first();
        if (Storage::exists('/public/media/' . $setting->value)) {
            Storage::delete('/public/media/' . $setting->value);
            $setting->delete();
        }
        return redirect()->back();

    }

    public function fonts()
    {
        $logo['heading_fonts_en'] = Setting::where('key', 'heading_fonts_en')->first();
        $logo['body_fonts_en'] = Setting::where('key', 'body_fonts_en')->first();
        $logo['heading_fonts_ar'] = Setting::where('key', 'heading_fonts_ar')->first();
        $logo['body_fonts_ar'] = Setting::where('key', 'body_fonts_ar')->first();
        return view('fonts.index', compact('logo'));
    }

    public function change_fonts()
    {
        try {
            $imagePath = 'public/fonts';
            if ($file = request()->file('heading_fonts_en')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'heading_fonts_en' . '.' . $ext;
                $file->storeAs($imagePath, $name);
                Setting::updateOrCreate(
                    ['key' => 'heading_fonts_en'],
                    ['label' => 'heading_fonts_en', 'value' => $name]
                );
            }
            if ($file = request()->file('body_fonts_en')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'body_fonts_en' . '.' . $ext;
                $file->storeAs($imagePath, $name);
                Setting::updateOrCreate(
                    ['key' => 'body_fonts_en'],
                    ['label' => 'body_fonts_en', 'value' => $name]
                );
            }
            if ($file = request()->file('heading_fonts_ar')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'heading_fonts_ar' . '.' . $ext;
                $file->storeAs($imagePath, $name);
                Setting::updateOrCreate(
                    ['key' => 'heading_fonts_ar'],
                    ['label' => 'heading_fonts_ar', 'value' => $name]
                );
            }
            if ($file = request()->file('body_fonts_ar')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'body_fonts_ar' . '.' . $ext;
                $file->storeAs($imagePath, $name);
                Setting::updateOrCreate(
                    ['key' => 'body_fonts_ar'],
                    ['label' => 'body_fonts_ar', 'value' => $name]
                );
            }

            return redirect()->back();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Storage::delete('/public/fonts/' . $name);
            return back()->with('error', 'Error: Something went wrong!');
        }
    }

}
