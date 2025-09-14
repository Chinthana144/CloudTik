@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Mikrotik Testing</h5>
        </div>
        <div class="card-body">

            <form action="{{ route('mikrotik.store') }}" method="post">
                @csrf
                <div class="col-md-6">
                    <label for="" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control">

                    <label for="" class="form-label">Password</label>
                    <input type="password" name="pwd" class="form-control">

                    <button type="submit" class="btn btn-primary m-2">Submit</button>
                </div>
            </form>

            {{-- @foreach ($users as $user)
                <p>{{ $user['name'] }}</p>
            @endforeach --}}

            <hr>

            <p>get profiles</p>
{{--
            @foreach ($profiles as $pro)
                <p>{{ $pro['name'] }}</p>
            @endforeach --}}


            <div>
                <form action="{{ route('mikrotik.checkConnection') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary m-2">Check Connection</button>
                </form>
            </div>

            <div>
                <form action="{{ route('mikrotik.bindmac') }}" method="post">
                    @csrf
                    <select name="cmb_camp" id="cmb_camp" class="form-select">
                        @foreach ($camps as $camp)
                            <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                        @endforeach
                    </select>

                    <input type="text" name="mac_address" class="form-control">

                    <button type="submit" class="btn btn-primary">Bind MAC Address</button>
                </form>
            </div>

            <div>
                @foreach ($users as $user)
                    {{ $user->name }}
                @endforeach
            </div>
        </div>
    </div>
@endsection
