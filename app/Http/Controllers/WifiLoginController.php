<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Customers;
use App\Models\Subscriptions;
use App\Services\HotspotUsers;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class WifiLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customer_id = $request->input('id');
        $customer = Customers::find($customer_id);

        $mac = $request->query('mac', null);  // if 'mac' doesn't exist, use null
        $ip = $request->query('ip', null);
        // $username = $request->query('username', null);
        $dst = $request->query('dst', null);

        return view('WifiLogin.customer_dashboard', compact('mac', 'ip', 'dst', 'customer'));
    }

    //AJAX login
    public function login(Request $request)
    {
        date_default_timezone_set('Asia/Dubai');

        $camp_id = $request->input('camp_id');
        $mac = $request->input('mac') ?? "";
        $username = $request->input('cust_username');
        $password = $request->input('cust_password');

        //camp data
        $camp_data = Camps::find($camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_pwd = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $hotspot_user = new HotspotUsers($host, $camp_user, $camp_pwd, $port);

        //search customer by username
        $customer = Customers::where('username', $username)
            ->where('password', $password)
            ->where('status', 1) //active
            ->first();

        if($customer){
            //check camp
            if($camp_id == $customer->camp_id){
                $customer_id = $customer->id;

                //check active subscriptions
                $active_subscription = Subscriptions::where('customer_id', $customer_id)
                    ->where('status', 1) //active
                    ->where('camp_id', $camp_id)
                    ->first();

                if($active_subscription){
                    /*
                    * assign subscription start and expire datetime only if null
                    * when user mac address changes, running state change to 'Active' state,
                    * hence subscription start and end time should not be changed.
                    */
                    //make it running
                    $active_subscription->status = 2; //running
                    $active_subscription->subscriptionStartTime ??= now();
                    $active_subscription->subscriptionEndTime ??= now()->addDays($active_subscription->package->duration);
                    $active_subscription->macAddress = $mac;
                    $active_subscription->save();

                    //update customer mac address
                    $customer->login_datetime ??= now();
                    $customer->expiry_datetime ??= now()->addDays($active_subscription->package->duration);
                    $customer->mac_address = $mac;
                    $customer->save();

                    //bind mac address to hotspot user
                    $hotspot_user->addHotspotUser($username, $password, $mac);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Login successful.',
                        'login_datetime' => $customer->login_datetime,
                        'expiry_datetime' => $customer->expiry_datetime,
                    ]);
                }//has active subscription
                else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'No active subscription found, please contact Sales Person.',
                    ]);
                }//no active subscription
            }//same camp
            else{
                return response()->json([
                'status' => 'error',
                'message' => 'Please login with correct camp login page.',
            ]);
            }//invalid camp
        }//has customer
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid username or password, please try again.',
            ]);
        }//no customer
    }//ajax login
    /*
    * validate customer login
    */

    //use this login in future
    public function  oldLogin(Request $request){
        date_default_timezone_set('Asia/Dubai');

        $camp_id = $request->input('camp_id');
        $mac = $request->input('mac');
        $ip = $request->input('ip');
        $link_login = $request->input('link_login');
        $username = $request->input('cust_username');
        $password = $request->input('cust_password');

        //camp data
        $camp_data = Camps::find($camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_pwd = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $hotspot_user = new HotspotUsers($host, $camp_user, $camp_pwd, $port);

        //search customer by username
        $customer = Customers::where('username', $username)
            ->where('password', $password)
            ->where('status', 1) //active
            ->first();

        if($customer){
            //check camp
            if($camp_id == $customer->camp_id){
                $customer_id = $customer->id;

                //check active subscriptions
                $active_subscription = Subscriptions::where('customer_id', $customer_id)
                    ->where('status', 1) //active
                    ->where('camp_id', $camp_id)
                    ->first();

                if($active_subscription){
                    /*
                    * assign subscription start and expire datetime only if null
                    * when user mac address changes, running state change to 'Active' state,
                    * hence subscription start and end time should not be changed.
                    */
                    //make it running
                    $active_subscription->status = 2; //running
                    $active_subscription->subscriptionStartTime ??= now();
                    $active_subscription->subscriptionEndTime ??= now()->addDays($active_subscription->package->duration);
                    $active_subscription->macAddress = $mac;
                    $active_subscription->save();

                    //update customer mac address
                    $customer->login_datetime ??= now();
                    $customer->expiry_datetime ??= now()->addDays($active_subscription->package->duration);
                    $customer->mac_address = $mac;
                    $customer->save();

                    //bind mac address to hotspot user
                    $hotspot_user->addHotspotUser($username, $password, $mac);

                    $hotspot_user->bindMacAddressToUser($username, $mac);

                    //redirect uri
                    $redirectUrl = 'https://cloudtik.trizent.net/userlogin?id=' . $customer->id;

                    return redirect($redirectUrl);
                }//active package
                else{
                    return redirect()->back()->with('error', 'No subscription found');
                }//no active or running subscription
            }//has camp
            else{
                return redirect()->back()->with('error', 'Please login with correct camp login page');
            }
        }//has customer
        else{
            return redirect()->back()->with('error', 'Invalid username or password, or hotspot service is not connected.');
        }//no customer

    }//login 1 method

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
        $camp_id = $request->input('camp_id', 1); //default camp id 1
        $customer_type_id = 1; //labor
        $customer_name = $request->input('customer_name');
        $contact_no = $request->input('contact_no');
        $customer_pwd = $request->input('customer_pwd');
        $customer_email = "";
        $username = $contact_no;
        $status = 1; //active

        $exists = Customers::where('username', $username)->exists();

        if ($exists) {
            return redirect()->route('wifilogin.register')
                ->with('error', 'This phone number is already registered. Please use a different phone number.');
        } else {
            Customers::create([
                'camp_id' =>  $camp_id,
                'customerType_id' => $customer_type_id,
                'fullname' => $customer_name,
                'phone' => $contact_no,
                'email' => $customer_email,
                'username' => $username,
                'password' => $customer_pwd,
                'status' => $status,
            ]);
            session()->flash('success', 'Shop added successfully!');
            return redirect()->route('wifilogin.index')
                ->with('success', 'You have successfully registered. Please login to continue.');
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

    public function register(Request $request){
        $camp_id = $request->input('camp_id', 1); //default camp id 1
        $camp = Camps::find($camp_id);

        return view('WifiLogin.customer_register', compact('camp'));
    }
}
