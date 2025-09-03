<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\ClientSubscriptions;
use App\Models\Subscriptions;
use App\Services\MikrotikServices;
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

    //show daily sale
    public function showDailySale(){
        $this_camp_id = Session::get('active_camp_id');

        $camp = Camps::find($this_camp_id);

        $monthly_target = (float)$camp->monthly_target;

        $today = date('Y-m-d');

        $daily_sale = Subscriptions::where('camp_id', $this_camp_id)
            ->whereDate('purchaseDate', $today)
            ->selectRaw('SUM(price) as daily_sale')
            ->first();

        $today_sale = $daily_sale->daily_sale ?? 0;

        //get monthly sale
        $currentMonth = now()->month;
        $currentYear  = now()->year;

        $month_sale = Subscriptions::where('camp_id', $this_camp_id)
            ->whereMonth('purchaseDate', $currentMonth)
            ->whereYear('purchaseDate', $currentYear)
            ->selectRaw('SUM(price) as monthly_sale')
            ->first();

        $monthly_sale = $month_sale->monthly_sale ?? 0;

        //client month sale
        $client_month_sale = ClientSubscriptions::where('camp_id', $this_camp_id)
            ->whereMonth('purchaseDate', $currentMonth)
            ->whereYear('purchaseDate', $currentYear)
            ->selectRaw('SUM(price) as client_monthly_sale')
            ->first();

        $client_monthly_sale = $client_month_sale->client_monthly_sale ?? 0;

        //remaining days
        $today = Carbon::today();
        $endOfMonth = Carbon::now()->endOfMonth();
        $remainingDays = $today->diffInDays($endOfMonth) ?? 1;

        //get remaining target
        $completed_target = (float)$monthly_sale - (float)$client_monthly_sale - (float)$today_sale;

        $pending_target = $monthly_target - $completed_target;

        $current_daily_target = $pending_target / $remainingDays;

        $ceiling = ceil($current_daily_target / 10) * 10;

        $transfer_amount = (float)$today_sale - $ceiling;

        $transfer_sale = 0;

        $subs = Subscriptions::where('camp_id', $this_camp_id)
            ->whereDate('purchaseDate', $today)
            ->get();

        foreach ($subs as $sub) {
            $price = (float)$sub->price;

            $transfer_sale += $price;

            if($transfer_sale >= $transfer_amount)
            {
                break;
            }
            else
            {
                //insert data to client table
                // $client_sub = ClientSubscriptions::create([
                //     'camp_id' => $sub->camp_id,
                //     'user_id' => $sub->user_id,
                //     'customer_id' => $sub->customer_id,
                //     'package_id' => $sub->package_id,
                //     'paymethod_id' => $sub->paymethod_id,
                //     'purchaseDate' => $sub->purchaseDate,
                //     'purchaseDateTime' => $sub->purchaseDateTime,
                //     'price' => $sub->price,
                //     'macAddress' => '0',
                //     'status' => $sub->status,
                // ]);
            }
        }//foreach

        return view('Mikrotik.daily_sale');
    }

    //make sale conclude
    public function dailySaleTransfer(){
        $camps = Camps::where('monthly_target', '>=', 0)
            ->where('status', 1)
            ->get();

        foreach ($camps as $camp) {
            $camp_id = $camp->id;

            $camp_id = $camp->id;
            $monthly_target = (float)$camp->monthly_target;

            $today = date('Y-m-d');
            $yesterday = date('Y-m-d', strtotime('-1 day'));

            $daily_sale = Subscriptions::where('camp_id', $camp_id)
                ->whereDate('purchaseDate', $yesterday)
                ->selectRaw('SUM(price) as daily_sale')
                ->first();

            $sale = $daily_sale->daily_sale ?? 0;

            if($sale > 0)
            {
                //get monthly sale
                $currentMonth = now()->month;
                $currentYear  = now()->year;

                $month_sale = Subscriptions::where('camp_id', $camp_id)
                    ->whereMonth('purchaseDate', $currentMonth)
                    ->whereYear('purchaseDate', $currentYear)
                    ->selectRaw('SUM(price) as monthly_sale')
                    ->first();

                $monthly_sale = $month_sale->monthly_sale ?? 0;

                //client month sale
                $client_month_sale = ClientSubscriptions::where('camp_id', $camp_id)
                    ->whereMonth('purchaseDate', $currentMonth)
                    ->whereYear('purchaseDate', $currentYear)
                    ->selectRaw('SUM(price) as client_monthly_sale')
                    ->first();

                $client_monthly_sale = $client_month_sale->client_monthly_sale ?? 0;

                //remaining days
                $today = Carbon::today();
                $endOfMonth = Carbon::now()->endOfMonth();
                $remainingDays = $today->diffInDays($endOfMonth) ?? 1;

                //get remaining target
                $completed_target = (float)$monthly_sale - (float)$client_monthly_sale - (float)$sale;

                $pending_target = $monthly_target - $completed_target;

                $current_daily_target = $pending_target / $remainingDays;

                //get upper rounded value of daily current target
                $ceiling = ceil($current_daily_target / 10) * 10;

                $transfer_amount = (float)$sale - $ceiling;

                $transfer_sale = 0;

                //check percentage
                /*
                * the ceiling amount is less than 30 percent of daily sale
                */
                if($sale * 0.3 > $ceiling)
                {
                    $subs = Subscriptions::where('camp_id', $camp_id)
                    ->whereDate('purchaseDate', $yesterday)
                    ->get();

                    foreach ($subs as $sub) {
                        $price = (float)$sub->price;

                        $transfer_sale += $price;

                        if($transfer_sale >= $transfer_amount)
                        {
                            break;
                        }
                        else
                        {
                            // insert data to client table
                            $client_sub = ClientSubscriptions::create([
                                'camp_id' => $sub->camp_id,
                                'user_id' => $sub->user_id,
                                'customer_id' => $sub->customer_id,
                                'package_id' => $sub->package_id,
                                'paymethod_id' => $sub->paymethod_id,
                                'purchaseDate' => $sub->purchaseDate,
                                'purchaseDateTime' => $sub->purchaseDateTime,
                                'price' => $sub->price,
                                'macAddress' => '0',
                                'status' => $sub->status,
                            ]);
                        }
                    }//foreach
                }//check sale
            }//has daily sale
        }//foreach

        return view('Mikrotik.daily_sale');
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
