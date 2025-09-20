@extends('CustomerProfile.cust_layout')

@section('content')

    <div id="div_customer_details">
        <h5>
            Hi, {{ $customer->fullname }}
            <br>
            {{ $customer->username }}
        </h5>
    </div>

    {{-- has running package --}}
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
@endsection
