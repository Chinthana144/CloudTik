@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Status</h5>
        </div>
        <div class="card-body">
            <div class="container container-md">
                <div class="card">
                    <div class="card-header">
                        <h5>Fetch Any</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Query</label>
                                <input type="text" name="fetch_any_query" id="fetch_any_query" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">&nbsp;</label>
                                <button type="submit" id="btn_fetch_any" class="btn btn-primary ">Fetch</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Mikrotik Identity</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">&nbsp;</label>
                                <button type="button" id="btn_get_identity" class="btn btn-primary ">Get Identity</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Mikrotik connection</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">&nbsp;</label>
                                <button type="button" id="btn_get_connection" class="btn btn-primary ">Get Connection</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Mikrotik DHCP lease</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">&nbsp;</label>
                                <button type="button" id="btn_dhcp_lease" class="btn btn-primary ">Get DHCP Lease</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Mikrotik Hotspot Active</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">&nbsp;</label>
                                <button type="button" id="btn_hotspot_active" class="btn btn-primary ">Get Hotspot Active</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- hotspot users --}}
                <div class="card">
                    <div class="card-header">
                        <h5>Hotspot User</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Username</label>
                                <input type="text" name="txt_username" id="txt_username" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">&nbsp;</label>
                                <button type="submit" id="btn_hotspot_user" class="btn btn-primary ">Fetch Hotspot User</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/mikrotik_status.js') }}"></script>
@endsection
