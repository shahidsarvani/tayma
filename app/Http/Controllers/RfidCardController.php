<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRfidCardRequest;
use App\Http\Requests\UpdateRfidCardRequest;
use App\Models\RfidCard;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RfidCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cards = RfidCard::with('screen')->get();
        return view('cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $screens = Screen::where('is_rfid', 1)->get();
        return view('cards.create', compact('screens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRfidCardRequest $request)
    {
        //
        // return $request;
        try {
            $data = $request->validated();
            RfidCard::create($data);
            return redirect()->route('cards.index')->with('success', 'RFID Card is added!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RfidCard  $rfidCard
     * @return \Illuminate\Http\Response
     */
    public function show(RfidCard $rfidCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RfidCard  $rfidCard
     * @return \Illuminate\Http\Response
     */
    public function edit(RfidCard $card)
    {
        //
        $screens = Screen::where('is_rfid', 1)->get();
        return view('cards.edit', compact('card', 'screens'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RfidCard  $rfidCard
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRfidCardRequest $request, RfidCard $card)
    {
        //
        try {
            $data = $request->validated();
            $card->update($data);
            return redirect()->route('cards.index')->with('success', 'RFID Card is updated!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RfidCard  $rfidCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(RfidCard $card)
    {
        //
        // return $card;
        try {
            $card->delete();
            return back()->with('success', 'RFID Card is deleted!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Error: Something went wrong!');
        }
    }
}
