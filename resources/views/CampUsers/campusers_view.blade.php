@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Camp Users
                <button class="btn btn-primary btn-sm float-end" id="btn_open_campusers">Add User</button>
            </h5>
        </div>
        <div class="card-body">

            <table class="table" id="tbl_campusers">
                <tr>
                    <th>Username</th>
                    <th>Camp Name</th>
                    <th>Action</th>
                    <th>Access</th>
                </tr>
                @foreach ($campusers as $campuser)
                    <tr data-id="{{ $campuser->id }}">
                        <td>{{ $campuser->users->name }}</td>
                        <td>{{ $campuser->camps->name }}</td>
                        <td>
                            <button class="btn btn-info btn_open_edit">Edit</button>
                        </td>
                        <td>
                            <form action="{{ route('campuser.delete') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="hide_campuser_id" value="{{ $campuser->id }}">
                                <button id="btn_remove" class="btn btn-danger">Remove</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    @include('CampUsers.campuser_modal')
    @include('CampUsers.campuser_edit_modal')

    <script src="{{ asset('js/campusers.js') }}"></script>
@endsection
