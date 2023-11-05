@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Vehicle</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('vehicles.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" id="model" name="model" required>
                            </div>

                            <div class="form-group">
                                <label for="make">Make</label>
                                <input type="text" class="form-control" id="make" name="make" required>
                            </div>

                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" id="color" name="color" required>
                            </div>

                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="number" class="form-control" id="year" name="year" required>
                            </div>
                            <div class="form-group">
                                <label for="photos">Fotos</label>
                                <input type="file" class="form-control" id="photos" name="photos[]" multiple>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="client_id" name="client_id"
                                    value="{{ Auth::user()->client->id }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Create Vehicle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
