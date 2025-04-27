@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                @if (is_null($camp))
                    Sales Reports
                @else
                    Sales Reports in <b>{{ $camp->name }}</b>
                @endif
            </h5>
        </div>
        <div class="card-body">
            <div class="col-md-6">
                <a href="/rpt_daily_sales" class="btn btn-primary">Daily Sale</a>
            </div>
        </div>
    </div>
@endsection
