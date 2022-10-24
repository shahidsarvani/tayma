<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\HardwareSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HardwareScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $hardware_schedule = HardwareSchedule::with('hardware')->get();
//        $days = Hardware::get_enums('day');
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];
        return view('hardwares.schedule.index', compact('hardware_schedule', 'days'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $days = Hardware::get_enums('day');
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];

        $hardware = Hardware::where('is_active', 1)->get();
        return view('hardwares.schedule.create', compact('days', 'hardware'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->except('_token');
            HardwareSchedule::create($data);
            return redirect()->route('schedule.index')->with('success', 'Hardware Schedule Added!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->route('schedule.index')->with('error', 'Error: Something went wrong!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];
        $schedule = HardwareSchedule::where('id', $id)->first();
//        $days = Hardware::get_enums('day');
        $hardware = Hardware::where('is_active', 1)->get();
        return view('hardwares.schedule.edit', compact('schedule', 'days', 'hardware'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
        $data = $request->except('_token');
        $hardwareSchedule = HardwareSchedule::find($id);
        $hardwareSchedule->update($data);
        return redirect()->route('schedule.index')->with('success', 'Hardware Schedule Updated!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->route('schedule.index')->with('error', 'Error: Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $hardwareSchedule = HardwareSchedule::find($id);
        $hardwareSchedule->delete();
            return redirect()->route('schedule.index')->with('success', 'Hardware Deleted Successfully!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->route('schedule.index')->with('error', 'Error: Something went wrong!');
        }

    }
}
