<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Customers;
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
        $customers = Customers::where('camp_id', $camp_id)->get();

        return view('Customers.customer_view', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $camps = Camps::where('status', 1)->get();

        return view('Customers.customer_add', compact('camps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cmb_camp' => 'required|integer',
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
                'fullname' => $validatedData['fullname'],
                'phone' => $validatedData['phone'],
                'username' => $validatedData['username'],
                'password' => $validatedData['password'],
                'status' => $stat,
            ]);
            session()->flash('success', 'Shop added successfully!');
            return redirect()->route('customer.store');
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
