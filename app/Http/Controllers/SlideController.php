<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Models\RfidCard;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $slides = Slide::with('card')->get();
        return view('slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cards = RfidCard::where('is_active', 1)->get();
        return view('slides.create', compact('cards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSlideRequest $request)
    {
        //
        // return $request;

        try {
            $data = $request->validated();
            return $data;
            $data = $request->except('_token', 'image_en', 'image_ar');
            $imagePath = 'public/media';
            if ($file = $request->file('image_en')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'image_en_' . md5(time()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['image_en'] = $name;
            }
            if ($file = $request->file('image_ar')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'image_ar_' . md5(time()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['image_ar'] = $name;
            }
            // return $data;

            Slide::create($data);
            return redirect()->route('slides.index')->with('success', 'Slide is added!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Storage::delete(['/public/media/' . $data['image_en'], '/public/media/' . $data['image_ar']]);
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function show(Slide $slide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
        //
        $cards = RfidCard::where('is_active', 1)->get();
        return view('slides.edit', compact('cards', 'slide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSlideRequest $request, Slide $slide)
    {
        //
        // return $slide;
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        //
    }
}
