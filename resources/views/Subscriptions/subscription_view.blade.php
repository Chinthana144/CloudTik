@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                Subscriptions in <b>{{ $subscriptions->first()->camp->name }}</b>
            </h5>
        </div>
        <div class="card-body">
            <table class="table" id="tbl_subscription">
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
                    <tr data-id="{{ $subs->id }}">
                        <td>{{ $subs->customer->fullname }}</td>
                        <td>{{ $subs->customer->phone }}</td>
                        <td>{{ $subs->package->name }}</td>
                        <td>{{ $subs->package->duration }}</td>
                        <td>{{ $subs->price }}</td>
                        <td>
                            @if ($subs->status == 1)
                                <p class="text-success border border-success rounded text-center">Active</p>
                            @elseif($subs->status == 2)
                                <p class="text-warning border border-warning rounded text-center">Pending</p>
                            @elseif($subs->status == 3)
                                <p class="text-primary border border-primary rounded text-center">Cancled</p>
                            @else
                                <p class="text-danger border border-danger rounded text-center">Expired</p>
                            @endif
                        </td>
                        <td>{{ $subs->user->name }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm btn_open_edit">Edit</button>
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

    @include('Subscriptions.subs_edit_modal')

    <script src="{{ asset('js/subscription.js') }}"></script>
@endsection
