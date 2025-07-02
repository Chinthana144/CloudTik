<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Customers;
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
        $default_camp_id = 1; // Default camp ID, can be changed as needed
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
                'camp_id' =>  $default_camp_id,
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

    public function register(){
        return view('WifiLogin.customer_register');
    }
}
