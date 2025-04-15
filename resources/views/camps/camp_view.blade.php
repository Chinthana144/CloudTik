@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                Camps
                <a href="/add-camp" class="btn btn-primary btn-sm float-end">Add Camp</a>
            </h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Host</th>
                    <th>Port</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach ($camps as $camp)
                    <tr>
                        <td>{{ $camp->name }}</td>
                        <td>{{ $camp->location }}</td>
                        <td>{{ $camp->mikritikIP }}</td>
                        <td>{{ $camp->mikritikPort }}</td>
                        <td>
                            @if ($camp->status == 1)
                                <p class="text-success">Active</p>
                            @else
                                <p class="text-danger">Inactive</p>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('camps.edit') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ $camp->id }}" name="hide_camp_id">
                                <button type="submit" class="btn btn-info">Edit</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
@endsection
