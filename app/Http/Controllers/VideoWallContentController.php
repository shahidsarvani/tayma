<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Menu;
use App\Models\Screen;
use App\Models\VideowallContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VideoWallContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $content = VideowallContent::with('menu', 'screen')->get();
        // return $content;
        return view('videowall_content.index', compact('content'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $screens = Screen::where('is_touch', 1)->where('screen_type', 'videowall')->get();
        return view('videowall_content.create', compact('screens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // return $request;

        try {
            $data = $request->except('_token');
            // return $data;
            VideowallContent::create($data);

            $slug = Screen::where('id', $request->screen_id)->first()->slug;
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
            }
            return redirect()->route('videowall.content.index')->with('success', 'Content Item is added!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $content = VideowallContent::find($id);
        $media = Media::where('lang', $content->lang)->where('menu_id', $content->menu_id)->get();
        // return $media;
        $all_menus = Menu::where('screen_type', 'videowall')->where('screen_id', $content->screen_id)->where('type', 'side')->get();
        $menus = array();
        foreach ($all_menus as $value) {
            $name = array();
            if ($value->parent) {
                array_unshift($name, $value->parent->name_en);
                if ($value->parent->parent) {
                    array_unshift($name, $value->parent->parent->name_en);
                    if ($value->parent->parent->parent) {
                        array_unshift($name, $value->parent->parent->parent->name_en);
                        if ($value->parent->parent->parent->parent) {
                            array_unshift($name, $value->parent->parent->parent->parent->name_en);
                        }
                    }
                }
            }
            array_push($name, $value->name_en);
            $name = implode(' -> ', $name);
            $temp = [
                'id' => $value->id,
                'name' => $name
            ];
            array_push($menus, $temp);
        }
        // return $menus;
        $screens = Screen::where('is_touch', 1)->where('screen_type', 'videowall')->get();
        return view('videowall_content.edit', compact('screens', 'content', 'menus', 'media'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // return $request;

        try {
            $data = $request->except('_token', '_method');
            // return $data;
            $content = VideowallContent::find($id);
            $content->update($data);

            $slug = Screen::where('id', $request->screen_id)->first()->slug;
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
            }
            return redirect()->route('videowall.content.index')->with('success', 'Content Item is updated!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
