<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Subscriptions;
use App\Services\HotspotUsers;
use Illuminate\Http\Request;

class WifiLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mac = $request->query('mac', null);  // if 'mac' doesn't exist, use null
        $ip = $request->query('ip', null);
        // $username = $request->query('username', null);
        $dst = $request->query('dst', null);

        return view('user-login', compact('mac', 'ip', 'dst'));
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
        $customer_name = $request->input('customer_name');
        $customer_pwd = $request->input('customer_pwd');
        $mac = $request->input('mac');

        //find customer
        $subscription = Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
            ->select('customers.username', 'customers.password', 'subscriptions.status')
            ->where('customers.username', $customer_name)
            ->where('customers.password', $customer_pwd)
            ->get();

        // dd([
        //     'username' => $customer_name,
        //     'password' => $customer_pwd,
        //     'mac' => $mac,
        //     'data' => $subscription,
        // ]);

        //check running packages
        $has_running = Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
            ->select('customers.username', 'customers.password', 'subscriptions.status')
            ->where('customers.username', $customer_name)
            ->where('customers.password', $customer_pwd)
            ->where('subscriptions.status', 2) //running
            ->exists();

        //check active packages
        $has_active = Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
            ->select('customers.username', 'customers.password', 'subscriptions.status')
            ->where('customers.username', $customer_name)
            ->where('customers.password', $customer_pwd)
            ->where('subscriptions.status', 1) //active
            ->exists();

        //check pending packages
        $has_pending = Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
            ->select('customers.username', 'customers.password', 'subscriptions.status')
            ->where('customers.username', $customer_name)
            ->where('customers.password', $customer_pwd)
            ->where('subscriptions.status', 3) //pending
            ->exists();

        if ($has_running) {
            $running_data =  Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
                ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
                ->select('subscriptions.id', 'customers.fullname', 'customers.username', 'customers.password', 'subscriptions.status', 'subscriptions.subscriptionStartTime', 'subscriptions.subscriptionEndTime', 'subscriptions.macAddress', 'packages.name', 'packages.duration', 'subscriptions.camp_id')
                ->where('customers.username', $customer_name)
                ->where('customers.password', $customer_pwd)
                ->where('subscriptions.status', 2) //running
                ->first();

            return view('WifiLogin.customer_dashboard', compact('running_data'));
        } //goto dashboard
        elseif ($has_active) {
            $active_data =  Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
                ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
                ->select('subscriptions.id as sub_id', 'customers.fullname', 'customers.username', 'customers.password', 'subscriptions.status', 'subscriptions.subscriptionStartTime', 'subscriptions.subscriptionEndTime', 'subscriptions.macAddress', 'packages.name as package_name', 'packages.duration', 'subscriptions.camp_id')
                ->where('customers.username', $customer_name)
                ->where('customers.password', $customer_pwd)
                ->where('subscriptions.status', 1) //active
                ->first();

            //update active => running
            $current_date = date('Y-m-d H:i:s');
            $end_date = date('Y-m-d H:i:s', strtotime('+30 days'));

            $subscription = Subscriptions::find($active_data->sub_id);
            $subscription->subscriptionStartTime = $current_date;
            $subscription->subscriptionEndTime = $end_date;
            //add mac address later cannot fetch now
            $subscription->status = 2; //added to running

            $subscription->save();

            $running_data = $subscription;

            //add user to mikrotik
            $camp_data = Camps::find($active_data->camp_id);
            $host = $camp_data->mikritikIP;
            $camp_user = $camp_data->mikrotikUsername;
            $camp_password = $camp_data->mikrotikPassword;
            $port = $camp_data->mikritikPort;

            $hotspot_user = new HotspotUsers($host, $camp_user, $camp_password, $port);

            $hotspot_user->addHotspotUser($customer_name, $customer_pwd, $active_data->package_name);

            return view('WifiLogin.customer_dashboard', compact('running_data'));
        } //update and goto dashboard
        elseif ($has_pending) {
            //add to mikrotik and update
            $pending_data =  Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
                ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
                ->select('subscriptions.id as sub_id', 'customers.fullname', 'customers.username', 'customers.password', 'subscriptions.status', 'subscriptions.subscriptionStartTime', 'subscriptions.subscriptionEndTime', 'subscriptions.macAddress', 'packages.name', 'packages.duration', 'subscriptions.camp_id')
                ->where('customers.username', $customer_name)
                ->where('customers.password', $customer_pwd)
                ->where('subscriptions.status', 3) //active
                ->first();

            //update pending => running
            $current_date = date('Y-m-d H:i:s');
            $end_date = date('Y-m-d H:i:s', strtotime('+30 days'));

            $subscription = Subscriptions::find($pending_data->id);
            $subscription->subscriptionStartTime = $current_date;
            $subscription->subscriptionEndTime = $end_date;
            //add mac address later cannot fetch now
            $subscription->status = 2; //added to running

            return view('WifiLogin.customer_dashboard', compact('pending_data'));
        } else {
            //redirect to login page with message
            return view('user-login');
        }
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
