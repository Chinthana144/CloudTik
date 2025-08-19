<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Services\MikrotikServices;
use App\Services\UserProfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MikrotikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service = new MikrotikServices();
        // $users = $service->getUsers();

        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_password = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        // $user_profile = new UserProfiles($host, $camp_user, $camp_password, $port);

        // $profiles = $user_profile->getPackages();

        if($service->isConnected) {
            // Fetch all users
            $users = $service->getUsers();
        } else {
            $users = []; // Return empty array if not connected

        }

        return view('Test.mikrotik', compact('users'));
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
        $user_name = $request->input('username');
        $user_pwd = $request->input('pwd');

        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_password = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $user_profile = new UserProfiles($host, $camp_user, $camp_password, $port);

        $user_profile->addHotspotUser($user_name, $user_pwd);
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

    public function checkConnection()
    {
        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_password = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $service = new MikrotikServices();
        // return $service->checkConnection();

        dd($service->checkConnection());
    }
}
