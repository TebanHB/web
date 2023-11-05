
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      @foreach($photos as $photo)
      <div class="col-md-4">
        <div class="thumbnail">
          <img src="{{ asset('storage/' . $photo->file_path)}}" alt="" style="height: 200px; width: 200px; object-fit: cover;">
          <div class="caption">
            <h3>{{ $photo->vehicle->make }}</h3>
            <p>{{ $photo->vehicle->model}}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
@endsection
