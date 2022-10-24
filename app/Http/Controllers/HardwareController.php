<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\HardwareSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $hardwares = Hardware::all();
        return view('hardwares.index', compact('hardwares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $days = Hardware::get_enums('day');
        // return $fields;
        return view('hardwares.create', compact('days'));
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
            $hardware = Hardware::create($data);
            $this->add_items($hardware->id, $request);
            return redirect()->route('hardwares.index')->with('success', 'Hardware Added!');
        } catch (\Throwable $th) {
            //throw $th;
            Log::info($th->getMessage());
            return redirect()->route('hardwares.index')->with('error', 'Error: Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hardware  $hardware
     * @return \Illuminate\Http\Response
     */
    public function show(Hardware $hardware)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hardware  $hardware
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $hardware = Hardware::find($id);
        // return $hardware;
        $days = Hardware::get_enums('day');
        return view('hardwares.edit', compact('hardware', 'days'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hardware  $hardware
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hardware $hardware)
    {
        //
        try {
            $data = $request->except('_token', '_method');
            $hardware->update($data);
            return redirect()->route('hardwares.index')->with('success', 'Hardware Updated!');
        } catch (\Throwable $th) {
            //throw $th;
            Log::info($th->getMessage());
            return redirect()->route('hardwares.index')->with('error', 'Error: Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hardware  $hardware
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hardware $hardware)
    {
        //
        try {
            $hardware->delete();
            return redirect()->route('hardwares.index')->with('success', 'Hardware deleted!');
        } catch (\Throwable $th) {
            //throw $th;
            Log::info($th->getMessage());
            return redirect()->route('hardwares.index')->with('error', 'Error: Something went wrong!');
        }
    }

    public function add_items($hardware_id, $request)
    {
        if($request->has('day') && count($request->day) > 0) {
            $now = Carbon::now();
            $records = array();
            foreach($request->day as $key=>$day) {
                $temp = array();
                $temp['hardware_id'] = $hardware_id;
                $temp['day'] = $day;
                $temp['start_time'] = $request->start_time[$key];
                $temp['end_time'] = $request->end_time[$key];
                $temp['is_active'] = $request->day_is_active[$key];
                $temp['created_at'] = $now;
                $temp['updated_at'] = $now;
                array_push($records, $temp);
            }
            HardwareSchedule::insert($records);
        }
    }
    public function remove_items($hardware)
    {
        $item_ids = $hardware->schedule_times->pluck('id');
        if(count($item_ids) > 0) {
            $items = HardwareSchedule::whereIn('id', $item_ids)->get();
            if(count($items) > 0) {
                foreach ($items as $item) {
                    $item->delete();
                }
            }
        }
    }
}
