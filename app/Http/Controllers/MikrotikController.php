<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\ClientSubscriptions;
use App\Models\Subscriptions;
use App\Services\MikrotikServices;
use App\Services\HotspotUsers;
use App\Services\MikrotikStatus;
use App\Services\UserProfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class MikrotikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $service = new MikrotikServices();
        // $users = $service->getUsers();

        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_pwd = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $camps = Camps::where('status', 1)->get();

        $hotspot_user = new HotspotUsers($host, $camp_user, $camp_pwd, $port);

        //get identity
        $response = $hotspot_user->getIdentity();

        return view('Mikrotik.mikrotik', compact('camps', 'response'));
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

        $hotspot_user = new HotspotUsers($host, $camp_user, $camp_password, $port);
        // $user_profile = new UserProfiles($host, $camp_user, $camp_password, $port);

        $hotspot_user->addHotspotUser($user_name, $user_pwd);

        return redirect()->route('mikrotik.hotspotusers');
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

    //bind mac address
    public function bindMac(Request $request){
        $camp_id = $request->input('cmb_camp');
        $mac_address = $request->input('mac_address');
        $username = $request->input('username');

        $camp = Camps::find($camp_id);

        $host = $camp->mikritikIP;
        $camp_user = $camp->mikrotikUsername;
        $camp_pwd = $camp->mikrotikPassword;
        $port = $camp->mikritikPort;

        $hotspot_user = new HotspotUsers($host, $camp_user, $camp_pwd, $port);

        $hotspot_user->bindMacAddressToUser($username, $mac_address);

        return redirect()->route('mikrotik.hotspotusers');
    }

    public function unbindMac(Request $request){
        $camp_id = $request->input('cmb_camp');
        $mac_address = $request->input('mac_address');

        $camp = Camps::find($camp_id);

        $host = $camp->mikritikIP;
        $camp_user = $camp->mikrotikUsername;
        $camp_pwd = $camp->mikrotikPassword;
        $port = $camp->mikritikPort;

        $hotspot_user = new HotspotUsers($host, $camp_user, $camp_pwd, $port);

        $hotspot_user->unbindMacAddressFromUser($mac_address);

        return redirect()->route('mikrotik.hotspotusers');
    }

    //show add users in mikrotik
    public function showAddUsers(){
        $camps = Camps::where('status', 1)->get();

        return view('Mikrotik.add_users', compact('camps'));
    }

    //show subscriptions in mikrotik
    public function showSubscription(){
        $camps = Camps::where('status', 1)->get();

        return view('Mikrotik.subscription', compact('camps'));
    }

    //============================ Mikrotik Status ============================//
    public function showStatus(){
        return view('Mikrotik.status');
    }

    public function fetchAny(Request $request)
    {
        $query = $request->input('query');

        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_password = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $mikrotik_status = new MikrotikStatus($host, $camp_user, $camp_password, $port);

        $response = $mikrotik_status->fetchAny($query);

        return response()->json($response);
    }

    public function getIdentity()
    {
        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_password = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $mikrotik_status = new MikrotikStatus($host, $camp_user, $camp_password, $port);

        $response = $mikrotik_status->getIdentity();

        return response()->json($response);
    }

    public function getConnection()
    {
        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_password = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $mikrotik_status = new MikrotikStatus($host, $camp_user, $camp_password, $port);

        $response = $mikrotik_status->getConnection();

        return response()->json($response);
    }

    public function getDhcpLease()
    {
        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_password = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $mikrotik_status = new MikrotikStatus($host, $camp_user, $camp_password, $port);

        $response = $mikrotik_status->dhcpLease();

        return response()->json($response);
    }

    public function getHotspotActive()
    {
        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_password = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $mikrotik_status = new MikrotikStatus($host, $camp_user, $camp_password, $port);

        $response = $mikrotik_status->hotspotActive();

        return response()->json($response);
    }

    public function getHotspotUser(Request $request)
    {
        $username = $request->input('username');

        $active_camp_id = Session::get('active_camp_id');
        $camp_data = Camps::find($active_camp_id);
        $host = $camp_data->mikritikIP;
        $camp_user = $camp_data->mikrotikUsername;
        $camp_password = $camp_data->mikrotikPassword;
        $port = $camp_data->mikritikPort;

        $hotspot_user = new HotspotUsers($host, $camp_user, $camp_password, $port);

        $response = $hotspot_user->getHotspotUser($username);

        return response()->json($response);
    }

}//class
