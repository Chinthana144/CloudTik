@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Subscriptions</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Package</th>
                    <th>Duration</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Action</th>
                </tr>

                @foreach ($subscriptions as $subs)
                    <tr>
                        <td>{{ $subs->customer->fullname }}</td>
                        <td>{{ $subs->customer->phone }}</td>
                        <td>{{ $subs->package->name }}</td>
                        <td>{{ $subs->package->duration }}</td>
                        <td>{{ $subs->price }}</td>
                        <td>
                            @if ($subs->status == 1)
                                <p class="text-success">Active</p>
                            @elseif($subs->status == 2)
                                <p class="text-warning">Pending</p>
                            @else
                                <p class="text-danger">Expired</p>
                            @endif
                        </td>
                        <td>{{ $subs->user->name }}</td>
                        <td>
                            <a href="/receipt-print?subscription_id={{ $subs->id }}"
                                class="btn btn-primary btn-sm">Print</a>
                        </td>
                    </tr>
                @endforeach
            </table>

            <!-- Pagination Links -->
            <div class="mt-3">
                {{ $subscriptions->links() }}
            </div>
        </div>
    </div>
@endsection
