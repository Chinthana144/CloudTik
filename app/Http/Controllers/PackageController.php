<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\CustomerType;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $active_camp_id = Session::get('active_camp_id');
        $packages = Packages::where('camp_id', $active_camp_id)->get();

        return view('Packages.packages_view', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customer_types = CustomerType::all();

        return view('Packages.packages_add', compact('customer_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cmb_customer_type' => 'required|integer',
            'name' => 'required|max:40',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            'bandwidth' => 'required|max:6',
            'speedLimit' => 'required|max:6',
        ]);

        $active_camp_id = Session::get('active_camp_id');
        $stat = $request->has('chk_package_stat') ? 1 : 0;

        Packages::create([
            'camp_id' => $active_camp_id,
            'customerType_id' => $validated['cmb_customer_type'],
            'name' => $validated['name'],
            'duration' => $validated['duration'],
            'price' => $validated['price'],
            'bandwidth' => $validated['bandwidth'],
            'speedLimit' => $validated['speedLimit'],
            'status' => $stat,
        ]);

        return redirect()->route('packages.create');
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
        $package_id = $request->input('hide_package_id');
        $package = Packages::find($package_id);

        $customer_types = CustomerType::all();

        return view('Packages.packages_edit', compact('package', 'customer_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $package_id = $request->input('hide_package_id');

        $package = Packages::find($package_id);
        $package->customerType_id = $request->input('cmb_customer_type');
        $package->name = $request->input('name');
        $package->duration = $request->input('duration');
        $package->price = $request->input('price');
        $package->bandwidth = $request->input('bandwidth');
        $package->speedLimit = $request->input('speedLimit');
        $package->status = $request->has('chk_package_stat') ? 1 : 0;

        $package->save();

        return redirect()->route('packages.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //ajax methods
    public function getCustomerPackages(Request $request)
    {
        $camp_id = Session::get('active_camp_id');
        $customer_id = $request->input('id');
        $customer = Customers::find($customer_id);
        $customer_type_id = $customer->customerType_id;

        $packages = Packages::where('camp_id', $camp_id)
            ->where('customerType_id', $customer_type_id)
            ->where('status', 1)
            ->get();

        return response()->json($packages);
    }
}
