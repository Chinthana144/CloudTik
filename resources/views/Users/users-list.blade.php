@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                Users
                <button id="btn_open_register" class="btn btn-primary btn-sm float-end">Register</button>
            </h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>Action</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    @include('Users.register_modal')

    <script src="{{ asset('js/users.js') }}"></script>
@endsection
