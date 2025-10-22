<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CloudTik Invoice</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <script src="{{ asset('js/select2.min.js') }}"></script>

</head>

<body>
    <div id="div_topbar">
        <div id="div_navbar">
            <a href="/home">
                <img src="{{ asset('images/invoice/home_nav.png') }}" alt="" class="img_navbar">
            </a>
            <button class="btn_navbar" id="btn_customers">
                <img src="{{ asset('images/invoice/customers_nav.png') }}" alt="" class="img_navbar">
            </button>
            <button class="btn_navbar" id="btn_sale">
                <img src="{{ asset('images/invoice/sale_nav.png') }}" alt="" class="img_navbar">
            </button>
            <button class="btn_navbar" id="btn_print">
                <img src="{{ asset('images/invoice/print_nav.png') }}" alt="" class="img_navbar">
            </button>
        </div>

        <div>
            <h5 id="invoice_title">{{ $camp->name }}</h5>
        </div>

        <div id="div_log">
            <button class="btn_navbar" id="btn_logout">
                <img src="{{ asset('images/invoice/logout_nav.png') }}" alt="" class="img_navbar">
            </button>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-header">
            <h5>Invoice</h5>
        </div>
        <div class="card-body">
            <div class="col-md-6 offset-md-3">
                <input type="hidden" name="hide_camp_id" id="hide_camp_id" value="{{ $camp->id }}">

                <label for="">Select Customer</label>
                <select name="cmb_customer" id="cmb_customer" class="form-control" style="width: 100%;">
                </select>

                <div id="div_customer_details">
                    <p id="p_customer_details">Select Customer</p>

                    <button type="button" class="btn btn-primary btn-sm" id="btn_customer_history">
                        Customer History
                    </button>
                </div>

                <div id="div_packages">
                    <label for="">Customer Packages</label>
                    <select name="cmb_packages" id="cmb_packages" class="form-select"></select>
                </div>

                <div id="div_package_details">
                    <p id="p_package_details">Select Package</p>

                    <form id="frm_subscription">
                        @csrf

                        <input type="hidden" name="hide_customer_id" id="hide_customer_id" value="0">
                        <input type="hidden" name="hide_package_id" id="hide_package_id" value="0">

                        <button type="submit" id="btn_add_subscription" class="btn btn-primary">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('Invoice.customer_modal')
    @include('Invoice.history_modal')

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('js/invoice.js') }}"></script>
</body>

</html>
