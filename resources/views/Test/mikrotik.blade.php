@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Mikrotik Testing</h5>
        </div>
        <div class="card-body">

            <form action="" method="post">
                <div class="col-md-6">
                    <label for="" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control">

                    <label for="" class="form-label">Password</label>
                    <input type="password" name="pwd" class="form-control">

                    <button type="submit" class="btn btn-primary m-2">Submit</button>
                </div>
            </form>

            @foreach ($users as $user)
                <p>{{ $user['name'] }}</p>
            @endforeach
        </div>
    </div>
@endsection
