<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VideoWallScreenController extends Controller
{

    public function index()
    {
        $screens = Screen::where('screen_type', 'videowall')->get();
        return view('video_wall_screens.index', compact('screens'));
    }


    public function create()
    {
        return view('video_wall_screens.create');
    }


    public function store(Request $request)
    {
        //
         //return $request;
        try {
            $data = $request->except('_token');
            $data['is_touch'] = 1;
            $data['is_model'] = 1;
            $data['is_rfid'] = 0;
            $data['screen_type'] = 'videowall';
            Screen::create($data);
            return redirect()->route('videowall.screens.index')->with('success', 'Video Wall Screen is added!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }


    public function edit($id)
    {
        //
        $screen = Screen::find($id);
        return view('video_wall_screens.edit', compact('screen'));
    }


    public function update(Request $request, $id)
    {
        //
        // return $request;
        try {
            $screen = Screen::find($id);
            $data = $request->except('_token', '_method');
            $screen->update($data);
            return redirect()->route('videowall.screens.index')->with('success', 'video_wall Screen is updated!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }


    public function destroy($id)
    {
        //
        try {
            $screen = Screen::find($id);
            $screen->delete();
            return redirect()->route('videowall.screens.index')->with('success', 'Video Wall Screen is deleted!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }

    public function getscreenmainmenu($screen_id)
    {
        // return $screen_id;
        $menus = Menu::where('screen_id', $screen_id)->where('level', 0)->select('name_en', 'id')->get();
        return response()->json($menus);
    }

    public function getscreensidemenu($screen_id)
    {
        // return $screen_id;

        $all_menus = Menu::where('screen_id', $screen_id)->where('type', 'side')->get();
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
        // $menus = Menu::where('screen_id', $screen_id)->where('level', 0)->select('name_en', 'id')->get();
        return response()->json($menus);
    }
}
