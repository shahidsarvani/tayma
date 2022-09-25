<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class PortraitScreenMediaController extends Controller
{
    //
    public function index()
    {
        $media = Media::all();
        return view('media.index', compact('media'));
    }

    public function portrait_video_index()
    {
        $media = Media::where('screen_type', 'portrait')->get();
        // return $media;
        $media_grouped = $media->groupBy('screen_slug');
        return view('portrait_media.index', compact('media_grouped'));
    }
    public function portrait_video_create()
    {
        $screens = Screen::where('is_touch', 1)->where('is_model', 1)->get();
        return view('portrait_media.create', compact('screens'));
    }
    public function portrait_video_store(Request $request)
    {
        //
        // return $request;
        if (!$request->lang) {
            return back()->with('error', 'Select Language');
        }

        if ($request->file_names) {
            foreach ($request->file_names as $index => $fileName) {
                // $media = Media::whereName($fileName)->first();
                $media = Media::create([
                    'lang' => $request->lang,
                    'name' => $fileName,
                    'screen_slug' => $request->screen_id,
                    'screen_type' => 'portrait',
                    'type' => $request->types[$index],
                ]);
            }
            return redirect()->route('portrait.media.index');
        } else {
            return back()->with('error', 'Error! Uploading Media File');
        }
    }
    public function portrait_video_delete($id)
    {
        $media = Media::findOrFail($id);
        Storage::delete('/public/media/' . $media->name);
        $media->delete();
        return redirect()->route('portrait.media.index')->with('success', 'Media deleted');
    }
}
