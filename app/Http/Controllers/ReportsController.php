<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function showSalesReports()
    {
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);

        return view('Reports.sales_reports', compact('camp'));
    }

    //show daily sales
    public function showDailySalesReport()
    {
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);

        $today = date('Y-m-d');
        $sales = Subscriptions::where('camp_id', $camp_id)
            ->whereDate('purchaseDateTime', $today)
            ->paginate(10);

        return view('Reports.rpt_daily_sales', compact('camp', 'sales'));
    }

    public function rptDailySalesSearch(Request $request)
    {
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $sales = Subscriptions::where('camp_id', $camp_id)
            ->whereBetween('purchaseDateTime', [$start_date, $end_date])
            ->paginate(10);

        return view('Reports.rpt_daily_sales', compact('camp', 'sales', 'start_date', 'end_date'));
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
        //
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
