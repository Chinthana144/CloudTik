<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Customers;
use App\Models\Packages;
use App\Models\Subscriptions;
use App\Services\HotspotUsers;
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
        $camp = Camps::find($camp_id);

        return view('Invoice.invoice', compact('camp'));
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
        $camp_data = Camps::find($camp_id);

        $customer_id = $request->input('hide_customer_id');
        $package_id = $request->input('hide_package_id');
        $purchased_date = date('Y-m-d');
        $purchased_time = date('Y-m-d H:i:s');

        //check customer expiry date
        $customer = Customers::find($customer_id);
        $expiry_datetime = $customer->expiry_datetime;

        //get price
        $package = Packages::find($package_id);
        $price = $package->price;

        $stat_id = 1; //active status id

        //check customer has subscription
        $existing_subscription = Subscriptions::where('customer_id', $customer_id)
            ->where('camp_id', $camp_id)
            ->exists();

        if ($existing_subscription) {
            $last_subscription = Subscriptions::where('customer_id', $customer_id)
                ->where('camp_id', $camp_id)
                ->orderBy('id', 'DESC')
                ->first();

            $last_status = $last_subscription->status;
            switch ($last_status) {
                case 1: //active
                    $stat_id = 1; //set status to pending
                case 2: //running
                    $stat_id = 2; //set status to running
                    //update customer expiry date
                    $new_expiry_datetime = date('Y-m-d H:i:s', strtotime($expiry_datetime . ' + ' . $package->duration . ' days'));
                    $customer->expiry_datetime = $new_expiry_datetime;
                    $customer->save();
                    break;
                case 3: //expired
                    $stat_id = 1; //set status to active
                    break;
                case 4: //cancled
                    $stat_id = 1; //set status to active
                    break;
            }//switch
        }//has subscription

        //set paymethod id for cash
        $paymethod_id = 1; //cash payment method id

        $subscription = Subscriptions::create([
            'camp_id' => $camp_id,
            'user_id' => $user_id,
            'customer_id' => $customer_id,
            'package_id' => $package_id,
            'paymethod_id' => $paymethod_id,
            'purchaseDate' => $purchased_date,
            'purchaseDateTime' => $purchased_time,
            'price' => $price,
            'macAddress' => '0',
            'status' => $stat_id,
        ]);

        return response()->json([
            'success' => true,
            'subscription_id' => $subscription->id,
            'message' => 'subscription added successfully',
        ]);
    }//store

    //add subscription from API
    public function addSubscriptionFromAPI(Request $request)
    {
        $user_id = $request->input('user_id');
        $camp_id = $request->input('camp_id');

        $customer_id = $request->input('customer_id');
        $package_id = $request->input('package_id');
        $purchased_date = date('Y-m-d');
        $purchased_time = date('Y-m-d H:i:s');

        //get price
        $package = Packages::find($package_id);
        $price = $package->price;

        //set status id to active
        $stat_id = 1;

        //set paymethod id for cash
        $paymethod_id = 1; //cash payment method id

        //create subscription
        $subscription = Subscriptions::create([
            'camp_id' => $camp_id,
            'user_id' => $user_id,
            'customer_id' => $customer_id,
            'package_id' => $package_id,
            'paymethod_id' => $paymethod_id,
            'purchaseDate' => $purchased_date,
            'purchaseDateTime' => $purchased_time,
            'price' => $price,
            'macAddress' => '0',
            'status' => $stat_id,
        ]);

        return response()->json([
            'success' => true,
            'subscription_id' => $subscription->id,
            'message' => 'Subscription added successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $camp_id = Session::get('active_camp_id');

        $subscriptions = Subscriptions::where('camp_id', $camp_id)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $camp = Camps::find($camp_id);

        return view('Subscriptions.subscription_view', compact('subscriptions', 'camp'));
    }

    public function subscriptionSearch(Request $request)
    {
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);
        $search = $request->input('subscription_search');

        $subscriptions = Subscriptions::where('camp_id', $camp_id)
            ->where(function ($query) use ($search) {
                $query->where('purchaseDateTime', 'LIKE', "%$search%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('fullname', 'LIKE', "%$search%")
                            ->orwhere('phone', 'LIKE', "%$search%")
                            ->orwhere('username', 'LIKE', "%$search%");
                    })
                    ->orWhereHas('package', function ($qu) use ($search) {
                        $qu->where('name', 'LIKE', "%$search%")
                            ->orwhere('duration', 'LIKE', "%$search%")
                            ->orwhere('price', 'LIKE', "%$search%");
                    });
            })
            ->paginate(10);

        return view('Subscriptions.subscription_view', compact('subscriptions', 'camp', 'search'));
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

    //receipt print
    public function receiptPrint(Request $request)
    {
        $subscription_id = $request->query('subscription_id');

        $subscription = Subscriptions::find($subscription_id);

        return view('Receipts.receipt01', compact('subscription'));
    }

    public function getOneSubscription(Request $request)
    {
        $subscription_id = $request->input('subscription_id');

        $subscription = Subscriptions::find($subscription_id);

        return response()->json([
            'success' => true,
            'subscription_id' => $subscription->id,
            'customer_name' => $subscription->customer->fullname,
            'username' => $subscription->customer->username,
            'package_name' => $subscription->package->name,
            'package_duration' => $subscription->package->duration,
            'status' => $subscription->status,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $subscription_id = $request->input('hide_subscription_id');
        $status_id = $request->input('cmb_status');

        $subscription = Subscriptions::find($subscription_id);

        $subscription->status = $status_id;

        $subscription->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully status changed',
        ]);
    } //update status

    public function getSubscriptionByCounter(Request $request)
    {
        $counter_id = $request->input('counter_id');

        $total = Subscriptions::where('counter_id', $counter_id)
            ->sum('price');

        $count = Subscriptions::where('counter_id', $counter_id)
            ->count('id');

        return response()->json([
            'success' => true,
            'invoice_count' => $count,
            'total' => $total,
        ]);
    }

    public function getSubscriptionByCustomer(Request $request)
    {
        $customer_id = $request->input('customer_id');

        $subs = Subscriptions::join('packages', 'subscriptions.package_id', '=', 'packages.id')
            ->where('customer_id', $customer_id)
            ->select('packages.name', 'packages.duration', 'subscriptions.subscriptionStartTime', 'subscriptions.subscriptionEndTime', 'subscriptions.price', 'subscriptions.status')
            ->orderBy('subscriptions.id', 'DESC')
            ->limit(10)
            ->get();

        return response()->json($subs, 200);
    }
}
