<?php

namespace App\Http\Controllers;

use App\Exports\SubscriptionExport;
use App\Models\Camps;
use App\Models\Subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

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

        if ($request->action == 'search') {
            $sales = Subscriptions::where('camp_id', $camp_id)
                ->whereBetween('purchaseDateTime', [$start_date, $end_date])
                ->paginate(10);

            return view('Reports.rpt_daily_sales', compact('camp', 'sales', 'start_date', 'end_date'));
        } //if search
        elseif ($request->action == 'excel') {
            $data = Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
                ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
                ->where('subscriptions.camp_id', $camp_id)
                ->whereBetween('purchaseDateTime', [$start_date, $end_date])
                ->get(['subscriptions.id', 'purchaseDateTime', 'customers.username', 'packages.name', 'packages.duration', 'subscriptions.price']);

            return Excel::download(
                new class($data) implements FromCollection, WithHeadings {
                    protected $data;
                    public function __construct($data)
                    {
                        $this->data = $data;
                    }
                    public function collection()
                    {
                        return $this->data;
                    }
                    public function headings(): array
                    {
                        return ['ID', 'DateTime', 'Customer', 'Package Name', 'Duration', 'Price'];
                    }
                },
                'my_excel.xlsx'
            );
        }
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
