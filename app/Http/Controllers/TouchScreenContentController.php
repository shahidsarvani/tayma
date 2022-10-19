<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Menu;
use App\Models\Screen;
use App\Models\TouchScreenContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TouchScreenContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $content = TouchScreenContent::with('menu')->get();
        return view('touchscreen_content.index', compact('content'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        //
        $layouts = [1, 2, 3, 4, 5];
        $all_menus = Menu::where('screen_type', 'touchtable')->where('type', 'side')->get();
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
            $name[] = $value->name_en;
            $name = implode(' -> ', $name);
            $temp = [
                'id' => $value->id,
                'name' => $name
            ];
            $menus[] = $temp;
        }
        return view('touchscreen_content.create', compact('menus', 'screens', 'layouts'));
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
            TouchScreenContent::create($data);

            $slug = Screen::where('screen_type', 'touchtable')->first()->slug;
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
            }
            return redirect()->route('touchtable.content.index')->with('success', 'Content Item is added!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TouchScreenContent  $touchScreenContent
     * @return \Illuminate\Http\Response
     */
    public function show(TouchScreenContent $touchScreenContent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TouchScreenContent  $touchScreenContent
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $all_menus = Menu::where('screen_type', 'touchtable')->get();
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
            $name[] = $value->name_en;
            $name = implode(' -> ', $name);
            $temp = [
                'id' => $value->id,
                'name' => $name
            ];
            $menus[] = $temp;
        }
        $content = TouchScreenContent::whereId($id)->first();
        $media = Media::where('menu_id', $content->menu_id)->where('lang', $content->lang)->get();
        return view('touchscreen_content.edit', compact('content', 'menus', 'media'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TouchScreenContent  $touchScreenContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->except('_token', '_method', 'file_names', 'types');
            // return $data;
            $touchscreen = TouchScreenContent::whereId($id)->update($data);

            $slug = Screen::where('screen_type', 'touchtable')->first()->slug;
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
            }
            return redirect()->route('touchtable.content.index')->with('success', 'Content Item is added!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TouchScreenContent  $touchScreenContent
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        TouchScreenContent::where('id', $id)->delete();
        return redirect()->back();
    }
}
