<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Packages;
use App\Models\Subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $camp_id = Session::get('active_camp_id');

        $counter = Counter::where('camp_id', $camp_id)
            ->where('user_id', $user_id)
            ->where('status', 1)
            ->get()
            ->first();

        return view('Invoice.invoice', compact('counter'));
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
        $counter_id = $request->input('hide_counter_id');
        $customer_id = $request->input('hide_customer_id');
        $package_id = $request->input('hide_package_id');
        $purchased_time = date('Y-m-d H:i:s');

        //get price
        $package = Packages::find($package_id);
        $price = $package->price;

        //check active packages
        $active_package_exists = Subscriptions::where("customer_id", $customer_id)
            ->where('status', 1)
            ->exists();

        $stat_id = $active_package_exists ? 2 : 1;

        $subscription = Subscriptions::create([
            'camp_id' => $camp_id,
            'user_id' => $user_id,
            'counter_id' => $counter_id,
            'customer_id' => $customer_id,
            'package_id' => $package_id,
            'purchaseDateTime' => $purchased_time,
            'price' => $price,
            'macAddress' => '0',
            'status' => $stat_id,
        ]);

        return response()->json([
            'success' => true,
            'subscription_id' => $subscription->id,
        ]);
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
