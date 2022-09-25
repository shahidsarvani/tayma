<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Menu;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class TouchScreenMediaController extends Controller
{
    //
    public function index()
    {
        $media = Media::all();
        return view('media.index', compact('media'));
    }

    public function touchtable_media_index()
    {
        $media = Media::whereHas('menu', function ($q) {
            $q->whereLevel(0);
        })->where('screen_type', 'touchtable')->get();
        // return $media;
        $media_grouped = $media->groupBy('menu_id');
        return view('touchtable_media.index', compact('media_grouped'));
    }
    public function touchtable_media_create()
    {
        // $screens = Screen::where('is_touch', 1)->where('screen_type', 'touchtable')->get();
        $menus = Menu::where('screen_type', 'touchtable')->where('level', 0)->get();
        // return $menus;
        return view('touchtable_media.create', compact('menus'));
    }
    public function touchtable_media_store(Request $request)
    {
        //
        // return $request;
        if (!$request->lang) {
            return back()->with('error', 'Select Language');
        }
        $slug = Screen::where('screen_type', 'touchtable')->first()->slug;
        // return $slug;
        if ($request->file_names) {
            foreach ($request->file_names as $index => $fileName) {
                // $media = Media::whereName($fileName)->first();
                $media = Media::create([
                    'lang' => $request->lang,
                    'name' => $fileName,
                    'screen_slug' => $slug,
                    'screen_type' => 'touchtable',
                    'menu_id' => $request->menu_id,
                    'type' => $request->types[$index],
                ]);
            }
            return redirect()->route('touchtable.media.index');
        } else {
            return back()->with('error', 'Error! Uploading Media File');
        }
    }
    public function touchtable_media_update(Request $request, $id)
    {
        // return $id;
        // return $request;
        try {
            $media = Media::find($id);
            $data = $request->except('_token', '_method');
            $media->update($data);
            return redirect()->route('touchtable.media.index')->with('success', 'Gallery Item is updated!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->with('error', 'Error: Something went wrong!');
        }
    }
    public function touchtable_media_delete($id)
    {
        $media = Media::findOrFail($id);
        Storage::delete('/public/media/' . $media->name);
        $media->delete();
        return redirect()->route('touchtable.media.index')->with('success', 'Media deleted');
    }
}
