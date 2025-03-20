@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Customers
                <a href="/add-customers" class="btn btn-primary btn-sm float-end">Add Customer</a>
            </h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Type</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Stat</th>
                    <th>Action</th>
                </tr>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->customerType->customerType }}</td>
                        <td>{{ $customer->fullname }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->username }}</td>
                        <td>{{ $customer->password }}</td>
                        <td>
                            @if ($customer->status == 1)
                                <p class="text-success">Active</p>
                            @else
                                <p class="text-danger">Inactive</p>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('customer.edit') }}" method="post">
                                @csrf
                                <input type="hidden" name="hide_customer_id" value="{{ $customer->id }}">
                                <button type="submit" class="btn btn-info btn-sm">Edit</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
