@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Add Package</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('packages.store') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <label for="" class="form-label">Select Customer Type</label>
                        <select name="cmb_customer_type" class="form-select" id="cmb_customer_type">
                            @foreach ($customer_types as $customer_type)
                                <option value="{{ $customer_type->id }}"> {{ $customer_type->customerType }}
                                </option>
                            @endforeach
                        </select>

                        <label for="" class="form-label mt-2">Package Name</label>
                        <input type="text" name="name" class="form-control">

                        <label for="" class="form-label mt-2">Duration(days)</label>
                        <input type="text" name="duration" class="form-control">

                        <label for="" class="form-label mt-2">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control">

                        <label for="" class="form-label mt-2">Bandwidth</label>
                        <input type="text" name="bandwidth" class="form-control">

                        <label for="" class="form-label mt-2">Speed Limit</label>
                        <input type="text" name="speedLimit" class="form-control">

                        <label for="" class="form-label mt-2">Package Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="chk_package_stat" id="chk_package_stat"
                                checked>
                            <label class="form-check-label" for="chk_package_stat">Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-25 float-end">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
