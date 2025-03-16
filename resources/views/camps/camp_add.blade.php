@extends('layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Add New Camp</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('camps.store') }}" method="post">
                <div class="col-md-6">
                    <label for="" class="form-label">Camp Name</label>
                    <input type="text" class="form-control" name="name">

                    <label for="" class="form-label mt-2">Camp Location</label>
                    <input type="text" class="form-control" name="name">

                    <label for="" class="form-label mt-2">Contact Persona Name</label>
                    <input type="text" class="form-control" name="name">

                    <label for="" class="form-label mt-2">Cantact Phone</label>
                    <input type="text" class="form-control" name="name">

                    <label for="" class="form-label mt-2">Camp email</label>
                    <input type="text" class="form-control" name="name">


                    <label for="" class="form-label mt-2">Camp Location</label>
                    <input type="text" class="form-control" name="name">

                    <label for="" class="form-label mt-2">Camp Location</label>
                    <input type="text" class="form-control" name="name">

                    <label for="" class="form-label mt-2">Camp Location</label>
                    <input type="text" class="form-control" name="name">

                    <label for="" class="form-label mt-2">Camp Location</label>
                    <input type="text" class="form-control" name="name">

                    <label for="" class="form-label mt-2">Camp Location</label>
                    <input type="text" class="form-control" name="name">

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="campstatus" checked>
                        <label class="form-check-label" for="campstatus">Active</label>
                    </div>

                    <button type="submit" class="btn btn-primary float-end">Save</button>
                </div>

            </form>
        </div>
    </div>
@endsection
