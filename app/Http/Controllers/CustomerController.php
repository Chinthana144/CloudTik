<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Customers;
use App\Models\CustomerType;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $camp_id = Session::get('active_camp_id');
        $customers = Customers::where('camp_id', $camp_id)->paginate(10);
        $camp = Camps::find($camp_id);

        return view('Customers.customer_view', compact('customers', 'camp'));
    }

    public function customerSearch(Request $request)
    {
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);
        $search = $request->input('customer_search');

        $customers = Customers::where(function ($query) use ($search) {
            $query->where('fullname', 'LIKE', "%$search%")
                ->orwhere('phone', 'LIKE', "%$search%")
                ->orwhere('email', 'LIKE', "%$search%")
                ->orwhere('username', 'LIKE', "%$search%");
        })->paginate(10);

        return view('Customers.customer_view', compact('customers', 'search', 'camp'));
    } //search customers

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $camps = Camps::where('status', 1)->get();
        $customer_types = CustomerType::all();

        return view('Customers.customer_add', compact('camps', 'customer_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cmb_camp' => 'required|integer',
            'cmb_customer_type' => 'required|integer',
            'fullname' => 'required|max:255',
            'phone' => 'required|max:13',
            'email' => 'max:255',
            'username' => 'required|unique:customers|max:20',
            'password' => 'required|max:20',
        ]);

        $stat = $request->has('chk_customer_stat') ? 1 : 0;

        $exists = Customers::where('username', $validatedData['username'])->exists();

        if ($exists) {
            return redirect()->route('customer.index');
            session()->flash('failed', 'camp user already added!');
        } else {
            Customers::create([
                'camp_id' => $validatedData['cmb_camp'],
                'customerType_id' => $validatedData['cmb_customer_type'],
                'fullname' => $validatedData['fullname'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'username' => $validatedData['username'],
                'password' => $validatedData['password'],
                'status' => $stat,
            ]);
            session()->flash('success', 'Shop added successfully!');
            return redirect()->route('customer.create');
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
    public function edit(Request $request)
    {
        $camps = Camps::where('status', 1)->get();
        $customer_types = CustomerType::all();

        $customer_id = $request->input('hide_customer_id');
        $customer = Customers::find($customer_id);

        return view('Customers.customer_edit', compact('customer', 'camps', 'customer_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $customer_id = $request->input('hide_customer_id');
        $customer = Customers::find($customer_id);

        $customer->camp_id = $request->input('cmb_camp');
        $customer->customerType_id = $request->input('cmb_customer_type');
        $customer->fullname = $request->input('fullname');
        $customer->phone = $request->input('phone');
        $customer->email = $request->input('email');
        $customer->username = $request->input('username');
        $customer->password = $request->input('password');
        $customer->status = $request->has('chk_customer_stat') ? 1 : 0;

        $customer->save();

        session()->flash('success', 'Shop added successfully!');
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //ajax methods
    public function getCustomers(Request $request)
    {
        $camp_id = Session::get('active_camp_id');
        $search = $request->input('q');

        $customer = Customers::where('camp_id', $camp_id)
            ->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%{$search}%")
                    ->orwhere('fullname', 'LIKE',  "%{$search}%")
                    ->orwhere('phone', 'LIKE',  "%{$search}%");
            })
            ->limit(20)
            ->get();

        return response()->json($customer);
    }

    public function getOneCustomer(Request $request)
    {
        $customer_id = $request->input('id');
        $customer = Customers::find($customer_id);

        return response()->json($customer);
    }

    //get customer types
    public function getCustomerTypes()
    {
        $customer_types = CustomerType::all();

        return response()->json($customer_types);
    }

    //store customer using AJAX
    public function storeOneCustomer(Request $request)
    {
        $camp_id = Session::get('active_camp_id');

        $customer = new Customers();

        $customer->camp_id = $camp_id;
        $customer->customerType_id = $request->input('cmb_customer_type');
        $customer->fullname = $request->input('fullname');
        $customer->phone = $request->input('phone');
        $customer->email = $request->input('email');
        $customer->username = $request->input('username');
        $customer->password = $request->input('password');
        $customer->status = $request->has('chk_customer_stat') ? 1 : 0;

        $exists = Customers::where('username',  $customer->username)->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Customer already exists',
            ]);
        } else {

            $customer->save();

            return response()->json([
                'success' => true,
                'message' => 'Customer added successfully',
            ]);
        }
    }

    public function getCustomerByUsername(Request $request)
    {
        $username = $request->input('username');

        $has_customer = Customers::where('username', $username)
            ->exists();

        return response()->json($has_customer);
    }
}
