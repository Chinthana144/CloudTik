<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Subscriptions;
use Illuminate\Http\Request;

class CustomerProfileController extends Controller
{
    public function index()
    {
        return view('CustomerProfile.cust_login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('pwd');

        $customer = Customers::where('username', $username)
                ->where('password', $password)
                ->first();

        if ($customer) {
            // Authentication successful
            $request->session()->put('customer_id', $customer->id);
            // redirect to customer home
            return redirect()->route('customer.custHome');
        } else {
            // Authentication failed
            return redirect()->back()->withErrors(['Invalid credentials']);
        }
    }//login


    public function custHome(){
        $customer_id = session('customer_id');

        $customer = Customers::find($customer_id);

        //running packages
        $running_package = Subscriptions::where('customer_id', $customer_id)
            ->where('status', 2)
            ->first();

        $active_packages = Subscriptions::where('customer_id', $customer_id)
            ->where('status', 1)
            ->get();

        if($customer){
            return view('CustomerProfile.cust_home', compact('customer', 'running_package', 'active_packages'));
        }
        else{
            return redirect()->route('customer.custLogin');
        }
    }

    public function logout(){
        session()->forget('customer_id');
        return redirect()->route('customer.custLogin');
    }
}//class
