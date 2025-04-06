<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                ->get()
                ->first();


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

    //close counter
    public function closeCounter(Request $request)
    {
        $counter_id = $request->input('hide_counter_close_id');
        //get counter total
        $counter_total = Subscriptions::where('counter_id', $counter_id)
            ->sum('price');

        $end_time = date('Y-m-d H:i:s');

        $counter = Counter::find($counter_id);

        $counter->endAmount = $counter_total;
        $counter->endTime = $end_time;
        $counter->status = 0;

        $counter->save();

        $totals = Subscriptions::where('counter_id', $counter_id)
            ->select('package_id', DB::raw('SUM(price) as total_price'))
            ->groupBy('package_id')
            ->get();

        return view('Receipts.counter01', compact('totals'));
    }
}
