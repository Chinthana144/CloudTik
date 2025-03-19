@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Add Customer</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('customer.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Select Camp</label>
                        <select name="cmb_camp" class="form-select" id="cmb_camp">
                            @foreach ($camps as $camp)
                                <option value="{{ $camp->id }}" @selected($camp->id == Session::get('active_camp_id'))> {{ $camp->name }}
                                </option>
                            @endforeach
                        </select>

                        <label for="" class="form-label mt-2">Full Name</label>
                        <input type="text" name="fullname" class="form-control">

                        <label for="" class="form-label mt-2">Phone</label>
                        <input type="text" name="phone" class="form-control">

                        <label for="" class="form-label mt-2">Email</label>
                        <input type="text" name="email" class="form-control">

                        <label for="" class="form-label mt-2">Username</label>
                        <input type="text" name="username" class="form-control">

                        <label for="" class="form-label mt-2">Password</label>
                        <input type="password" name="password" class="form-control">

                        <label for="" class="form-label mt-2">Customer Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="chk_customer_stat" name="chk_customer_stat"
                                checked>
                            <label class="form-check-label" for="chk_customer_stat">Active
                                input</label>
                        </div>

                        <button type="submit" class="btn btn-primary float-end w-25">Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
