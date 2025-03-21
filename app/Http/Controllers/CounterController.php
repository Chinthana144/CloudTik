<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $camp_id = Session::get('active_camp_id');

        $exists = Counter::where('camp_id', $camp_id)
            ->where('user_id', $user_id)
            ->where('status', 1)
            ->exists();

        if ($exists) {
            $counter = Counter::where('camp_id', $camp_id)
                ->where('user_id', $user_id)
                ->where('status', 1)
                ->get();

            return view('Invoice.invoice', compact('counter'));
        } else {
            return view('Counters.counter');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $camp_id = Session::get('active_camp_id');
        $start_amount = $request->input('counterStartAmount');
        $end_amount = $start_amount;
        $start_time = date('Y-m-d H:i:s');
        $end_time = date('Y-m-d H:i:s');
        $status = 1;

        $counter = Counter::create([
            'camp_id' => $camp_id,
            'user_id' => $user_id,
            'startAmount' => $start_amount,
            'endAmount' => $end_amount,
            'startTime' => $start_time,
            'endTime' => $end_time,
            'status' => $status,
        ]);

        return redirect()->route('invoice.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
