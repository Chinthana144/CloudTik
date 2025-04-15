@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                @if (is_null($camp))
                    Packages
                @else
                    Packages in <b>{{ $camp->name }}</b>
                @endif
                <a href="/add-packages" class="btn btn-primary btn-sm float-end">Add Package</a>
            </h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Duration<br>(Days)</th>
                    <th>Price<br>(AED)</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach ($packages as $package)
                    <tr>
                        <td>{{ $package->customerType->customerType }}</td>
                        <td>{{ $package->name }}</td>
                        <td>{{ $package->duration }}</td>
                        <td>{{ $package->price }}</td>
                        <td>
                            @if ($package->status == 1)
                                <p class="text-success">Active</p>
                            @else
                                <p class="text-danger">Inactive</p>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('packages.edit') }}" method="post">
                                @csrf
                                <input type="hidden" name="hide_package_id" value="{{ $package->id }}">
                                <button type="submit" class="btn btn-info btn-sm">Edit</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
