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
            <p>content</p>
        </div>
    </div>

    @include('Users.register_modal')

    <script src="{{ asset('js/users.js') }}"></script>
@endsection
