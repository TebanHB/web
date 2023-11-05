
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('All Vehicles') }}</div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Make') }}</th>
                                <th>{{ __('Model') }}</th>
                                <th>{{ __('Year') }}</th>
                                <th>{{ __('Color') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($vehicles->isEmpty())
                                <tr>
                                    <td colspan="4">{{ __('No vehicles found') }}</td>
                                </tr>
                                
                            @endif
                            @foreach ($vehicles as $vehicle)
                            <tr>
                                <td>{{ $vehicle->make }}</td>
                                <td>{{ $vehicle->model }}</td>
                                <td>{{ $vehicle->year }}</td>
                                <td>{{ $vehicle->color }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('vehicles.photos', $vehicle->id) }}" class="btn btn-primary">Ver fotos</a>
                                
                                        <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Borrar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
