<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Customers;
use App\Models\CustomerType;
use App\Models\Packages;
use App\Services\UserProfiles;
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
        $packages = Packages::where('camp_id', $active_camp_id)
            ->where('status', 1)
            ->get();
        $camp = Camps::find($active_camp_id);

        return view('Packages.packages_view', compact('packages', 'camp'));
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
        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_password = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $user_profile = new UserProfiles($host, $camp_user, $camp_password, $port);

        if ($user_profile->CheckConnection()) {
            $validated = $request->validate([
                'cmb_customer_type' => 'required|integer',
                'name' => 'required|max:40',
                'duration' => 'required|integer',
                'price' => 'required|numeric',
                'bandwidth' => 'required|max:6',
                'downloadlimit' => 'required|max:6',
                'uploadlimit' => 'required|max:6',
            ]);

            $stat = $request->has('chk_package_stat') ? 1 : 0;

            Packages::create([
                'camp_id' => $active_camp_id,
                'customerType_id' => $validated['cmb_customer_type'],
                'name' => $validated['name'],
                'duration' => $validated['duration'],
                'price' => $validated['price'],
                'bandwidth' => $validated['bandwidth'],
                'downloadlimit' => $validated['downloadlimit'],
                'uploadlimit' => $validated['uploadlimit'],
                'status' => $stat,
            ]);

            //creating user profiles in mikrotik
            $camp_data = Camps::find($active_camp_id);
            $host = $camp_data->mikritikIP;
            $camp_user = $camp_data->mikrotikUsername;
            $camp_password = $camp_data->mikrotikPassword;
            $port = $camp_data->mikritikPort;

            $user_profile = new UserProfiles($host, $camp_user, $camp_password, $port);

            $user_profile->createPackage($validated['name'], $validated['downloadlimit'], $validated['uploadlimit'], $validated['duration']);

            return redirect()->route('packages.create');
        } //connection OK
        else {
            return redirect()->back()
                ->with('error', 'Unable to connect to the Network Host, Please check connection.');
        } //host connection failed
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
        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_password = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $user_profile = new UserProfiles($host, $camp_user, $camp_password, $port);

        if ($user_profile->CheckConnection()) {
            $package_id = $request->input('hide_package_id');

            $package = Packages::find($package_id);
            $old_name = $package->name;

            $package->customerType_id = $request->input('cmb_customer_type');
            $package->name = $request->input('name');
            $package->duration = $request->input('duration');
            $package->price = $request->input('price');
            $package->bandwidth = $request->input('bandwidth');
            $package->downloadlimit = $request->input('downloadlimit');
            $package->uploadlimit = $request->input('uploadlimit');
            $package->status = $request->has('chk_package_stat') ? 1 : 0;

            $package->save();

            //update is mikrotik
            $user_profile->updatePackage($old_name, $request->input('name'), $request->input('downloadlimit'), $request->input('uploadlimit'), $request->input('duration'));

            return redirect()->route('packages.index');
        } //ok
        else {
            return redirect()->back()
                ->with('error', 'Unable to connect to the Network Host, Please check connection.');
        }
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

    public function getOnePackage(Request $request)
    {
        $package_id = $request->input('package_id');

        $package = Packages::find($package_id);

        return response()->json($package);
    } //get one package
}
