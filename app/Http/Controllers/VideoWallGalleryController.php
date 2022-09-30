<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Menu;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VideoWallGalleryController extends Controller
{
    //
    public function index()
    {
        $media = Media::whereHas('menu', function ($q) {
            $q->whereLevel(0);
        })->where('screen_type', 'videowall')->get();
        $media_grouped = $media->groupBy('menu_id');
        // return $media_grouped;
        return view('videowall_gallery.index', compact('media_grouped'));
    }
    public function create()
    {
        $screens = Screen::where('is_touch', 1)->where('screen_type', 'videowall')->get();
        // $menus = Menu::where('screen_type', 'videowall')->where('level', 0)->get();
        // return $menus;
        return view('videowall_gallery.create', compact('screens'));
    }
    public function store(Request $request)
    {
        //
        // return $request;
        if (!$request->lang) {
            return back()->with('error', 'Select Language');
        }
        $slug = Screen::where('id', $request->screen_id)->first()->slug;
        // return $slug;
        if ($request->file_names) {
            foreach ($request->file_names as $index => $fileName) {
                // $media = Media::whereName($fileName)->first();
                $media = Media::create([
                    'lang' => $request->lang,
                    'name' => $fileName,
                    'screen_slug' => $slug,
                    'screen_type' => 'videowall',
                    'menu_id' => $request->menu_id,
                    'type' => $request->types[$index],
                ]);
            }
            return redirect()->route('videowall.gallery.index');
        } else {
            return back()->with('error', 'Error! Uploading Media File');
        }
    }
    public function update(Request $request, $id)
    {
        // return $id;
        // return $request;
        try {
            $media = Media::find($id);
            $data = $request->except('_token', '_method');
            $media->update($data);
            return redirect()->route('videowall.gallery.index')->with('success', 'Gallery Item is updated!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->with('error', 'Error: Something went wrong!');
        }
    }
    public function delete($id)
    {
        $media = Media::findOrFail($id);
        Storage::delete('/public/media/' . $media->name);
        $media->delete();
        return redirect()->back()->with('success', 'Media deleted');
//        return redirect()->route('videowall.gallery.index')->with('success', 'Media deleted');
    }
}
