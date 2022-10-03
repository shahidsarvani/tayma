<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Menu;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VideoWallMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $menus = Menu::with('parent', 'screen')->where('screen_type', 'videowall')->get();
        return view('videowallscreen_menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $screens = Screen::where('screen_type', 'videowall')->whereIsTouch(1)->get();
        $all_menus = Menu::with('parent')->where('screen_type', 'videowall')->where('is_active', 1)->get();
        $menus = array();
        foreach ($all_menus as $menu) {
            $name = array();
            if ($menu->parent) {
                array_unshift($name, $menu->parent->name_en);
                if ($menu->parent->parent) {
                    array_unshift($name, $menu->parent->parent->name_en);
                    if ($menu->parent->parent->parent) {
                        array_unshift($name, $menu->parent->parent->parent->name_en);
                        if ($menu->parent->parent->parent->parent) {
                            array_unshift($name, $menu->parent->parent->parent->parent->name_en);
                        }
                    }
                }
            }
            array_push($name, $menu->name_en);
            $name = implode(' -> ', $name);
            $temp = [
                'id' => $menu->id,
                'name' => $name
            ];
            array_push($menus, $temp);
        }
        // return $menus;
        return view('videowallscreen_menus.create', compact('menus', 'screens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $data = $request->except('_token', 'intro_video', 'image_en', 'image_ar', 'icon_en', 'icon_ar');
            // return $data;
            if (!$request->menu_id) {
                // return $data;
                $data['menu_id'] = 0;
            }
            $imagePath = 'public/media';
            if ($file = $request->file('intro_video')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'intro_video_' . md5(uniqId()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['intro_video'] = $name;
            }
            if ($file = $request->file('image_en')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'image_en_' . md5(uniqId()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['image_en'] = $name;
            }
            if ($file = $request->file('image_ar')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'image_ar_' . md5(uniqId()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['image_ar'] = $name;
            }
            if ($file = $request->file('icon_en')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'icon_en_' . md5(uniqId()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['icon_en'] = $name;
            }
            if ($file = $request->file('icon_ar')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'icon_ar_' . md5(uniqId()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['icon_ar'] = $name;
            }
            if ($file = $request->file('bg_image')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'bg_' . md5(uniqId()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['bg_image'] = $name;
            }
            $data['screen_type'] = 'videowall';
            // return $data;

            Menu::create($data);
            return redirect()->route('videowall.menus.index')->with('success', 'Menu is added!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            if ((Arr::exists($data, 'image_en') && $data['image_en'] !== '') || (Arr::exists($data, 'image_ar') && $data['image_ar'] !== '')) {
                Storage::delete(['/public/media/' . $data['image_en'], '/public/media/' . $data['image_ar']]);
            }
            if ((Arr::exists($data, 'icon_en') && $data['icon_en'] !== '') || (Arr::exists($data, 'icon_ar') && $data['icon_ar'] !== '')) {
                Storage::delete(['/public/media/' . $data['icon_en'], '/public/media/' . $data['icon_ar']]);
            }
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
        $menu = Menu::with('parent')->find($id);

        $screens = Screen::where('screen_type', 'videowall')->whereIsTouch(1)->get();
        $all_menus = Menu::with('parent')->where('screen_type', 'videowall')->where('is_active', 1)->get();

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

        return view('videowallscreen_menus.edit', compact('menus', 'menu', 'screens'));
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

        $menu = Menu::find($id);
        // return $menu;
        // return $request;
        try {
            $data = $request->except('_token', 'image_en', 'image_ar', 'icon_en', 'icon_ar');
            // return $data;
            if (!$request->menu_id) {
                // return $data;
                $data['menu_id'] = 0;
            }
            if ($request->type === 'footer') {
                Storage::delete(['/public/media/' . $menu->image_en, '/public/media/' . $menu->image_ar]);
                $data['image_en'] = null;
                $data['image_ar'] = null;
            } elseif ($request->type === 'main') {
                Storage::delete(['/public/media/' . $menu->icon_en, '/public/media/' . $menu->icon_ar]);
                $data['icon_en'] = null;
                $data['icon_ar'] = null;
            } else {
                Storage::delete(['/public/media/' . $menu->image_en, '/public/media/' . $menu->image_ar]);
                Storage::delete(['/public/media/' . $menu->icon_en, '/public/media/' . $menu->icon_ar]);
                $data['image_en'] = null;
                $data['image_ar'] = null;
                $data['icon_en'] = null;
                $data['icon_ar'] = null;
            }
            $imagePath = 'public/media';
            if ($file = $request->file('bg_image')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'bg_' . md5(uniqId()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['bg_image'] = $name;
            }
            if ($file = $request->file('image_en')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'image_en_' . md5(uniqId()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['image_en'] = $name;
            }
            if ($file = $request->file('image_ar')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'image_ar_' . md5(uniqId()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['image_ar'] = $name;
            }
            if ($file = $request->file('icon_en')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'icon_en_' . md5(uniqId()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['icon_en'] = $name;
            }
            if ($file = $request->file('icon_ar')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'icon_ar_' . md5(uniqId()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['icon_ar'] = $name;
            }
            // return $data;
            $menu->update($data);
            return redirect()->route('videowall.menus.index')->with('success', 'Menu is updated!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            if ((Arr::exists($data, 'image_en') && $data['image_en'] !== '') || (Arr::exists($data, 'image_ar') && $data['image_ar'] !== '')) {
                Storage::delete(['/public/media/' . $data['image_en'], '/public/media/' . $data['image_ar']]);
            }
            if ((Arr::exists($data, 'icon_en') && $data['icon_en'] !== '') || (Arr::exists($data, 'icon_ar') && $data['icon_ar'] !== '')) {
                Storage::delete(['/public/media/' . $data['icon_en'], '/public/media/' . $data['icon_ar']]);
            }
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
        try {
            $menu = Menu::find($id);
            if ($menu->type === 'footer') {
                Storage::delete(['/public/media/' . $menu->icon_en, '/public/media/' . $menu->icon_ar]);
            } elseif ($menu->type === 'main') {
                Storage::delete(['/public/media/' . $menu->image_en, '/public/media/' . $menu->image_ar]);
            }
            $menu->delete();
            return redirect()->route('videowall.menus.index')->with('success', 'Menu is deleted!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }

    public function removeBgImage($id) {
        $menu = Menu::where('id', $id)->first();
        Helper::removePhysicalFile('media/' . $menu->bg_image);
        $menu->bg_image = null;
        $menu->save();
        return redirect()->back()->with('success', 'Image deleted successfully!');
    }

    public function removeIntroVideo($id): \Illuminate\Http\RedirectResponse
    {
        $menu = Menu::where('id', $id)->first();
        Helper::removePhysicalFile('media/' . $menu->bg_image);
        $menu->intro_video = null;
        $menu->save();
        return redirect()->back()->with('success', 'Video deleted successfully!');
    }
}
