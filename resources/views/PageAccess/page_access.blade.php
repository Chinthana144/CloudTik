@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                Page Access
                <button type="button" id="btn_create_access" class="btn btn-primary btn-sm float-end">Add Access</button>
            </h5>
        </div>
        <div class="card-body">

            <table class="table" id="tbl_role_pages">
                <tr>
                    <th>No</th>
                    <th>Role</th>
                    <th>Page</th>
                    <th>Permission</th>
                    <th>Action</th>
                </tr>
                @foreach ($role_pages as $rolepage)
                    <tr data-id='{{ $rolepage->id }}'>
                        <td>1</td>
                        <td>{{ $rolepage->role->name }}</td>
                        <td>{{ $rolepage->page->pagename }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input chk_access" type="checkbox" role="switch"
                                    id="role_access_{{ $rolepage->id }}" {{ $rolepage->permissions ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_access_{{ $rolepage->id }}">Access</label>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm btn_change">change</button>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>

    @include('PageAccess.page_create_modal')

    <script src="{{ asset('js/pageaccess.js') }}"></script>
@endsection
