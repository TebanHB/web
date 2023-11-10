@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Service Request</h1>

    <form action="{{ route('service_requests.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="location"><h2>Ubicacion</h2></label>
            <div id="map" style="height: 400px; width: 100%; display: none"><h1> Solicite su ubicacion</h1></div>
            <input type="hidden" class="form-control" id="location" name="location" required>
            <button type="button" id="get_location" class="btn btn-primary">Get Location</button>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="photos">Photos</label>
            <input type="file" class="form-control" id="photos" name="photos[]" multiple>
        </div>
        <button id="submit" disabled type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLiZOnEOdbn1pP9n96DFUzT1WUXszhDP8&callback=initMap"></script>
<script>
    document.getElementById('get_location').addEventListener('click', function() {
        var submitButton = document.getElementById('submit');
        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var location = position.coords.latitude + ', ' + position.coords.longitude;
            document.getElementById('location').value = location;
        });
    } else {
        alert('Geolocation is not supported by this browser.');
    }
    submitButton.disabled = false;
    document.getElementById('map').style.display = 'block';
});
</script>
<script>
    document.getElementById('get_location').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var location = position.coords.latitude + ', ' + position.coords.longitude;
                document.getElementById('location').value = location;
                initMap(); // Call the initMap function after getting the location
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });

    function initMap() {
        var location = document.getElementById('location').value.split(', ');
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            center: {lat: parseFloat(location[0]), lng: parseFloat(location[1])}
        });
        var marker = new google.maps.Marker({
            position: {lat: parseFloat(location[0]), lng: parseFloat(location[1])},
            map: map
        });
    }
</script>
@endsection