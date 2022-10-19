<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Menu;
use App\Models\TimelineItem;
use App\Models\TimelineMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TouchScreenTimelineItemController extends Controller
{
    //
    public function index()
    {
        $timeline_items = TimelineItem::all();
        return view('touchscreen_timeline.index', compact('timeline_items'));
    }

    public function create()
    {
        $all_menus = Menu::where('screen_type', 'touchtable')->where('type', 'side')->where('is_timeline', 1)->get();
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
        return view('touchscreen_timeline.create', compact('menus'));
    }

    public function store(Request $request)
    {
        // return $request;

        try {
            $data = $request->except('_token');
            // return $data;
            $item = TimelineItem::create($data);

            // $slug = Screen::where('screen_type', 'touchtable')->first()->slug;
            if ($request->file_names) {
                foreach ($request->file_names as $index => $fileName) {
                    // $media = Media::whereName($fileName)->first();
                    $media = TimelineMedia::create([
                        'timeline_item_id' => $item->id,
                        'lang' => $request->lang,
                        'name' => $fileName,
                        // 'screen_slug' => $slug,
                        // 'screen_type' => 'touchtable',
                        'menu_id' => $request->menu_id,
                        'type' => $request->types[$index],
                    ]);
                }
            }
            return redirect()->route('touchtable.timeline.index')->with('success', 'Timeline Item is added!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }

    public function edit($id)
    {
        $timeline_item = TimelineItem::with('timeline_media')->find($id);
        $media = TimelineMedia::where('timeline_item_id', $id)->get();
        // return $timeline_item;

        $all_menus = Menu::where('screen_type', 'touchtable')->where('type', 'side')->where('is_timeline', 1)->get();
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
        return view('touchscreen_timeline.edit', compact('menus', 'timeline_item', 'media'));
    }

    public function update(Request $request, $id)
    {
        // return $request;
        // return $id;

        $timeline_item = TimelineItem::find($id);

        try {
            $data = $request->except('_token');
            // return $data;
            $item = $timeline_item->update($data);

            // $slug = Screen::where('screen_type', 'touchtable')->first()->slug;
            if ($request->file_names) {
                foreach ($request->file_names as $index => $fileName) {
                    // $media = Media::whereName($fileName)->first();
                    $media = TimelineMedia::create([
                        'timeline_item_id' => $id,
                        'lang' => $request->lang,
                        'name' => $fileName,
                        // 'screen_slug' => $slug,
                        // 'screen_type' => 'touchtable',
                        'menu_id' => $request->menu_id,
                        'type' => $request->types[$index],
                    ]);
                }
            }
            return redirect()->route('touchtable.timeline.index')->with('success', 'Timeline Item is updated!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }

    public function destroy($id)
    {
        try {
            $timeline_item = TimelineItem::find($id);
            $media = TimelineMedia::where('lang', $timeline_item->lang)->where('timeline_item_id', $timeline_item->id)->get();
            foreach ($media as  $item) {
                Storage::delete('/public/media/' . $item->name);
                $item->delete();
            }
            $timeline_item->delete();
            return redirect()->route('touchtable.timeline.index')->with('success', 'Timeline Item is deleted!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }
}
