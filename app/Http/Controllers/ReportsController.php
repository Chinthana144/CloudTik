<?php

namespace App\Http\Controllers;

use App\Exports\SubscriptionExport;
use App\Models\Camps;
use App\Models\CampUsers;
use App\Models\Subscriptions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $camp_name = $camp->name;

        $today = date('Y-m-d');

        $start_date = $request->input('start_date') ?? $today;
        $end_date = $request->input('end_date') ?? $today;

        switch($request->action){
            case 'search':
                $sales = Subscriptions::where('camp_id', $camp_id)
                    ->whereBetween('purchaseDateTime', [$start_date, $end_date])
                    ->paginate(10);

                return view('Reports.rpt_daily_sales', compact('camp', 'sales', 'start_date', 'end_date'));
                break;

            case 'excel':
                $data = Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
                    ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
                    ->where('subscriptions.camp_id', $camp_id)
                    ->whereBetween('purchaseDate', [$start_date, $end_date])
                    ->get(['subscriptions.id as id', 'purchaseDate', 'customers.fullname', 'customers.username', 'packages.name', 'packages.duration', 'subscriptions.price']);

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
                            return ['ID', 'Date Time', 'Customer Name', 'Username', 'Package Name', 'Duration (days)', 'Price'];
                        }
                    },
                    'daily_sales_from_'.$start_date.'_to_'. $end_date .'.xlsx'
                );
            break;

            case 'pdf':
                $data = Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
                    ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
                    ->where('subscriptions.camp_id', $camp_id)
                    ->whereBetween('purchaseDate', [$start_date, $end_date])
                    ->get(['subscriptions.id as id', 'purchaseDate', 'customers.fullname as fullname', 'customers.username as username', 'packages.name as name', 'packages.duration as duration', 'subscriptions.price as price']);

                $pdf = Pdf::loadView('pdf.sales_pdf', compact('data','camp_name','start_date','end_date'));
                return $pdf->stream('daily_sales_from_'.$start_date.'_to_'. $end_date .'.pdf');
            break;

            default:
                # code...
            break;
        }//switch

        // if ($request->action == 'search') {
        //     $sales = Subscriptions::where('camp_id', $camp_id)
        //         ->whereBetween('purchaseDate', [$start_date, $end_date])
        //         ->paginate(10);

        //     return view('Reports.rpt_daily_sales', compact('camp', 'sales', 'start_date', 'end_date'));
        // } //if search
        // elseif ($request->action == 'excel') {
        //     $data = Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
        //         ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
        //         ->where('subscriptions.camp_id', $camp_id)
        //         ->whereBetween('purchaseDate', [$start_date, $end_date])
        //         ->get(['subscriptions.id', 'purchaseDate', 'customers.username', 'packages.name', 'packages.duration', 'subscriptions.price']);

        //     return Excel::download(
        //         new class($data) implements FromCollection, WithHeadings {
        //             protected $data;
        //             public function __construct($data)
        //             {
        //                 $this->data = $data;
        //             }
        //             public function collection()
        //             {
        //                 return $this->data;
        //             }
        //             public function headings(): array
        //             {
        //                 return ['ID', 'Date Time', 'Customer', 'Package Name', 'Duration', 'Price'];
        //             }
        //         },
        //         'daily_sales_from_'.$start_date.'_to_'. $end_date .'.xlsx'
        //     );
        // }
        // elseif($request->action == 'pdf') {
        //     $data = Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
        //         ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
        //         ->where('subscriptions.camp_id', $camp_id)
        //         ->whereBetween('purchaseDate', [$start_date, $end_date])
        //         ->get(['subscriptions.id as id', 'purchaseDate', 'customers.fullname', 'customers.username', 'packages.name', 'packages.duration', 'subscriptions.price']);

        //     $pdf = Pdf::loadView('Reports.sales_pdf', compact('data', 'camp_name', 'start_date', 'end_date'));
        //     return $pdf->stream('daily_sales_from_'.$start_date.'_to_'. $end_date .'.pdf');
        // }
    }

    public function showSaleSummaryReport()
    {
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);

        $today = date('Y-m-d');

        $sales = Subscriptions::selectRaw('package_id, SUM(subscriptions.price) as total_sales')
            ->where('subscriptions.camp_id', $camp_id)
            ->whereDate('purchaseDate', $today)
            ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
            ->groupBy('package_id')
            ->paginate(10);

        return view('Reports.rpt_sales_summary', compact('camp', 'sales'));
    }

    public function rptSalesSummarySearch(Request $request){
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);
        $camp_name = $camp->name;

        $today = date('Y-m-d');

        $start_date = $request->input('start_date') ?? $today;
        $end_date = $request->input('end_date') ?? $today;

        switch ($request->action) {
            case 'search':
                $sales = Subscriptions::selectRaw('package_id, SUM(subscriptions.price) as total_sales')
                ->where('subscriptions.camp_id', $camp_id)
                ->whereBetween('purchaseDate', [$start_date, $end_date])
                ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
                ->groupBy('package_id')
                ->paginate(10);
                return view('Reports.rpt_sales_summary', compact('camp', 'sales', 'start_date', 'end_date'));
                break;

            case 'excel':
                 $data = Subscriptions::join('packages', 'subscriptions.package_id', '=', 'packages.id')
                    ->where('subscriptions.camp_id', $camp_id)
                    ->whereBetween('purchaseDate', [$start_date, $end_date])
                    ->selectRaw('packages.name, COUNT(*) as package_count, SUM(subscriptions.price) as total_sales')
                    ->groupBy('subscriptions.package_id', 'packages.name')
                    ->get();

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
                            return ['Package Name', 'Package Count', 'Sale'];
                        }
                    },
                    'sales_summary_from_'.$start_date.'_to_'. $end_date .'.xlsx'
                );

                break;
            case 'pdf':
                $data = Subscriptions::join('packages', 'subscriptions.package_id', '=', 'packages.id')
                    ->where('subscriptions.camp_id', $camp_id)
                    ->whereBetween('purchaseDate', [$start_date, $end_date])
                    ->selectRaw('packages.name, COUNT(*) as package_count, SUM(subscriptions.price) as total_sales')
                    ->groupBy('subscriptions.package_id', 'packages.name')
                    ->get();

                $pdf = Pdf::loadView('pdf.sales_summary_pdf', compact('data', 'camp_name', 'start_date', 'end_date'));
                return $pdf->stream('daily_sales_from_'.$start_date.'_to_'. $end_date .'.pdf');
                break;

            default:
                # code...
                break;
        }//switch
    }

    /*
    * user sales report
    */
    public function showUserSalesReport()
    {
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);
        $users = CampUsers::selectRaw('users.id, users.name')
            ->where('camp_id', $camp_id)
            ->join('users', 'camp_users.user_id', '=', 'users.id')
            ->get();

        $today = date('Y-m-d');

        $sales = Subscriptions::where('camp_id', $camp_id)
            ->whereDate('purchaseDate', $today)
            ->paginate(10);

        return view('Reports.rpt_user_sales', compact('camp', 'users', 'sales'));
    }

    public function rptUserSalesSearch(Request $request){
        $camp_id = Session::get('active_camp_id');
        $camp = Camps::find($camp_id);
        $camp_name = $camp->name;

        $today = date('Y-m-d');

        $selected_user = $request->input('cmb_salesman') ?? null;
        $user = User::find($selected_user);
        $user_name = $user->name;
        $start_date = $request->input('start_date') ?? $today;
        $end_date = $request->input('end_date') ?? $today;

        switch($request->action){
            case 'search':
                $sales = Subscriptions::where('camp_id', $camp_id)
                    ->whereBetween('purchaseDate', [$start_date, $end_date])
                    ->where('user_id', $selected_user)
                    ->paginate(10);

                return view('Reports.rpt_user_sales', compact('camp', 'sales', 'start_date', 'end_date', 'selected_user'));
            break;

            case 'excel':
                $data = Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
                    ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
                    ->join('users', 'subscriptions.user_id', '=', 'users.id')
                    ->where('subscriptions.camp_id', $camp_id)
                    ->whereBetween('purchaseDate', [$start_date, $end_date])
                    ->where('subscriptions.user_id', $selected_user)
                    ->get(['subscriptions.id as id', 'purchaseDate', 'customers.username', 'packages.name', 'packages.duration', 'subscriptions.price', 'users.name as user_name']);

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
                            return ['ID', 'Date Time', 'Customer', 'Package Name', 'Duration (days)', 'Price', 'Salesman'];
                        }
                    },
                    'user_sales_from_'.$start_date.'_to_'. $end_date .'.xlsx'
                );
            break;

            case 'pdf':
                $data = Subscriptions::join('customers', 'subscriptions.customer_id', '=', 'customers.id')
                    ->join('packages', 'subscriptions.package_id', '=', 'packages.id')
                    ->join('users', 'subscriptions.user_id', '=', 'users.id')
                    ->where('subscriptions.camp_id', $camp_id)
                    ->whereBetween('purchaseDate', [$start_date, $end_date])
                    ->where('subscriptions.user_id', $selected_user)
                    ->get(['subscriptions.id as id', 'purchaseDate', 'customers.username as username', 'packages.name as name', 'packages.duration as duration', 'subscriptions.price as price', 'users.name as user_name']);

                $pdf = Pdf::loadView('pdf.user_sale_pdf', compact('data','camp_name','start_date','end_date', 'user_name'));
                return $pdf->stream('user_sales_from_'.$start_date.'_to_'. $end_date .'.pdf');
            break;
        }//switch
    }//user sales search

}
