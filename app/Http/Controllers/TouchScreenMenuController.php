<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Menu;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TouchScreenMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $menus = Menu::with('parent')->where('screen_type', 'touchtable')->get();
        return view('touchscreen_menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $all_menus = Menu::with('parent')->where('screen_type', 'touchtable')->where('is_active', 1)->get();
        $screens = Screen::where('screen_type', 'touchtable')->whereIsTouch(1)->get();
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
        return view('touchscreen_menus.create', compact('menus', 'screens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // return $request;
        try {
            $data = $request->except('_token', 'image_en', 'image_ar', 'icon_en', 'icon_ar', 'bg_image');
            // return $data;
            if (!$request->menu_id) {
                // return $data;
                $data['menu_id'] = 0;
            }
            $imagePath = 'public/media';
            if ($file = $request->file('image_en')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'image_en_' . md5(time()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['image_en'] = $name;
            }
            if ($file = $request->file('bg_image')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'media_' . md5(time()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['bg_image'] = $name;
            }
            if ($file = $request->file('image_ar')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'image_ar_' . md5(time()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['image_ar'] = $name;
            }
            if ($file = $request->file('icon_en')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'icon_en_' . md5(time()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['icon_en'] = $name;
            }
            if ($file = $request->file('icon_ar')) {
                $ext = $file->getClientOriginalExtension();
                $name = 'icon_ar_' . md5(time()) . '.' . $ext;
                $file->storeAs($imagePath, $name);
                $data['icon_ar'] = $name;
            }
//            $data['screen_id'] = Screen::where('screen_type', 'touchtable')->first()->id;
            $data['screen_type'] = 'touchtable';
            // return $data;

            $menu = Menu::create($data);
            $slug = Screen::where('id', $request->screen_id)->first()->slug;
            if ($request->file_names) {
                foreach ($request->file_names as $index => $fileName) {
                    $media[$index] = Media::create([
                        'lang' => 'en',
                        'name' => $fileName,
                        'screen_slug' => $slug,
                        'screen_type' => 'touchtable',
                        'menu_id' => $menu->id,
                        'type' => $request->types[$index],
                    ]);
                }
            }
            return redirect()->route('touchtable.menus.index')->with('success', 'Menu is added!');
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
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $menu = Menu::with('parent')->find($id);
        $media = Media::where('screen_type', 'touchtable')->where('menu_id', $id)->get();
        $all_menus = Menu::with('parent')->where('screen_type', 'touchtable')->where('is_active', 1)->get();
        $screens = Screen::where('screen_type', 'touchtable')->whereIsTouch(1)->get();
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
        // return $menu;
        return view('touchscreen_menus.edit', compact('menus', 'menu', 'screens', 'media'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
        // return $menu;
        // return $request;
//        try {
        $data = $request->except('_token', 'image_en', 'image_ar', 'icon_en', 'icon_ar', 'bg_image');
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
            $name = 'media_' . md5(time()) . '.' . $ext;
            $file->storeAs($imagePath, $name);
            $data['bg_image'] = $name;
        }
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
        if ($file = $request->file('icon_en')) {
            $ext = $file->getClientOriginalExtension();
            $name = 'icon_en_' . md5(time()) . '.' . $ext;
            $file->storeAs($imagePath, $name);
            $data['icon_en'] = $name;
        }
        if ($file = $request->file('icon_ar')) {
            $ext = $file->getClientOriginalExtension();
            $name = 'icon_ar_' . md5(time()) . '.' . $ext;
            $file->storeAs($imagePath, $name);
            $data['icon_ar'] = $name;
        }
        $screen = Screen::where('id', $request->screen_id)->first();

        if ($request->file_names) {
            foreach ($request->file_names as $index => $fileName) {
                // $media = Media::whereName($fileName)->first();
                $media = Media::create([
                    'lang' => 'en',
                    'name' => $fileName,
                    'screen_slug' => $screen->slug,
                    'screen_type' => 'touchtable',
                    'menu_id' => $menu->id,
                    'type' => $request->types[$index],
                ]);
            }
        }
        // return $data;
        $menu->update($data);
        return redirect()->route('touchtable.menus.index')->with('success', 'Menu is updated!');
//        } catch (\Throwable $th) {
//            Log::error($th->getMessage());
//            if ((Arr::exists($data, 'image_en') && $data['image_en'] !== '') || (Arr::exists($data, 'image_ar') && $data['image_ar'] !== '')) {
//                Storage::delete(['/public/media/' . $data['image_en'], '/public/media/' . $data['image_ar']]);
//            }
//            if ((Arr::exists($data, 'icon_en') && $data['icon_en'] !== '') || (Arr::exists($data, 'icon_ar') && $data['icon_ar'] !== '')) {
//                Storage::delete(['/public/media/' . $data['icon_en'], '/public/media/' . $data['icon_ar']]);
//            }
//            return redirect()->back()->with('error', 'Error: Something went wrong!');
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
        try {
            if ($menu->type === 'footer') {
                Storage::delete(['/public/media/' . $menu->icon_en, '/public/media/' . $menu->icon_ar]);
            } elseif ($menu->type === 'main') {
                Storage::delete(['/public/media/' . $menu->image_en, '/public/media/' . $menu->image_ar]);
            }
            $menu->delete();
            return redirect()->route('touchtable.menus.index')->with('success', 'Menu is deleted!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }
}
