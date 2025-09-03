@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Daily Sale</h5>
        </div>
        <div class="card-body">
            <p>calculate daily sale</p>

            <br>
            {{ $today_sale }}

            <br>
            {{ $month_sale->monthly_sale }}

            <br>
            complete - {{ $transfer_amount }}
        </div>
    </div>
@endsection
