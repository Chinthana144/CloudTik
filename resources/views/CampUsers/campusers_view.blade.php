@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Camp Users
                <small><button class="btn btn-primary float-end" id="btn_open_campusers">Add User</button></small>
            </h5>
        </div>
        <div class="card-body">

            <table class="table">
                <tr>
                    <th>Username</th>
                    <th>Camp Name</th>
                    <th>Action</th>
                    <th>Access</th>
                </tr>
                @foreach ($campusers as $campuser)
                    <tr>
                        <td>{{ $campuser->users->name }}</td>
                        <td>{{ $campuser->camps->name }}</td>
                        <td>
                            <button id="btn_open_edit" class="btn btn-info">Edit</button>
                        </td>
                        <td>
                            <button id="btn_remove" class="btn btn-danger">Remove</button>
                        </td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    @include('CampUsers.campuser_modal')

    <script src="{{ asset('js/campusers.js') }}"></script>
@endsection
