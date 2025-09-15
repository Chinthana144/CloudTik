@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Manual Subscriptions</h5>
        </div>
        <div class="card-body">
            <div class="col-md-6">
                <form action="" method="post">
                    <label for="">Select Camp</label>
                    <select name="cmb_camp" id="cmb_camp" class="form-select">
                        @foreach ($camps as $camp)
                            <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                        @endforeach
                    </select>

                    <label for="">Select Customer</label>
                    <select name="cmb_customer" id="cmb_customer"></select>
                </form>
            </div>

        </div>
    </div>
@endsection
