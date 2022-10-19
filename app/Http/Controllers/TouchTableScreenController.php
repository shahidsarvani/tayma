<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TouchTableScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $screens = Screen::where('screen_type', 'touchtable')->get();
        return view('touch_table_screens.index', compact('screens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('touch_table_screens.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->except('_token');
            $data['is_touch'] = 1;
            $data['is_model'] = 1;
            $data['is_rfid'] = 0;
            $data['screen_type'] = 'touchtable';
            Screen::create($data);
            return redirect()->route('touchtable.screens.index')->with('success', 'Touchtable Screen is added!');
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
        $screen = Screen::find($id);
        return view('touch_table_screens.edit', compact('screen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $screen = Screen::find($id);
            $data = $request->except('_token', '_method');
            $screen->update($data);
            return redirect()->route('touchtable.screens.index')->with('success', 'Touchtable Screen is updated!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $screen = Screen::find($id);
            $screen->delete();
            return redirect()->route('touchtable.screens.index')->with('success', 'Touchtable Screen is deleted!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }
}
