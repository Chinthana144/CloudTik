@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                @if (is_null($camp))
                    Customers
                @else
                    Customers in <b>{{ $camp->name }}</b>
                @endif
            </h5>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    @can('create', App\Models\Customer::class)
                        <a href="/add-customers" class="btn btn-primary">Add Customer</a>
                    @endcan

                </div>
                <div class="col-md-6">
                    <form action="{{ route('customer.search') }}" method="get">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="customer_search" class="form-control" placeholder="Search..."
                                value="{{ isset($search) ? $search : '' }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table_responsive">
                <table class="table">
                    <tr>
                        <th>Type</th>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Expire Date</th>
                        @can('update', App\Models\Customer::class)
                            <th>Action</th>
                        @endcan

                    </tr>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->customerType->customerType }}</td>
                            <td>{{ $customer->fullname }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->username }}</td>
                            <td>{{ $customer->password }}</td>
                            <td>
                                {{ $customer->expiry_datetime != null ? $customer->expiry_datetime : 'N/A' }}
                            </td>
                            @can('update', App\Models\Customer::class)
                            <td>
                                <form action="{{ route('customer.edit') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="hide_customer_id" value="{{ $customer->id }}">
                                    <button type="submit" class="btn btn-info btn-sm">Edit</button>
                                </form>
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                </table>
            </div>

            <div>
                {{ $customers->links() }}
            </div>
        </div>
    </div>
@endsection
