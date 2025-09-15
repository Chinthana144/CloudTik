<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trizent Infratech</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cust_profile.css') }}">
</head>
<body>
    <div id="div_top_bar">
        <div>
            Welcome, {{ $customer->fullname}} <br>
            Username: {{ $customer->username }} <br>
        </div>
        <div>
            <a href="/cust_logout" id="btn_logout">Logout</a>
        </div>
    </div>

    @if ($running_package)
        <div>
            <h4>
                Expire Date: <strong>{{ $customer->expiry_datetime }}</strong>
            </h4>
        </div>
    @endif

    {{-- has active packages --}}
    @if ($active_packages->count() > 0)
        <div id="div_active_packages">
            <h3>Active Packages</h3>
            @foreach ($active_packages as $package)
                <div class="div_package">
                    <h5>{{ $package->package->name }}</h5>
                    <p class="p_date">Date: <strong>{{ $package->purchaseDate }}</strong></p>
                    <p class="p_duration">Duration: <strong>{{ $package->package->duration }} Days</strong></p>
                    <p class="p_price">Price: <strong> {{ $package->price }} AED</strong></p>
                </div>
            @endforeach
        </div>
    @endif

    <div id="div_footer">
        <p>
            &copy; 2025 Trizent Infratech. All rights reserved.
            Powered by Trizent Infratech
        </p>

    </div>
</body>
</html>
