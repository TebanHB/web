@extends('layouts.app')
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLiZOnEOdbn1pP9n96DFUzT1WUXszhDP8&callback=initMap"></script>
@section('content')
    <div class="container">
        <h2>All Service Requests</h2>
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 15%;"></th>
                    <th style="width: 85%;">Descrption</th>
                    <!-- Add other fields as necessary -->
                </tr>
            </thead>
            <tbody>
                @foreach ($serviceRequests as $serviceRequest)
                    <tr>
                        <td>
                            <a href="#" class="btn btn-primary" data-toggle="modal"
                                data-target="#photosModal{{ $serviceRequest->id }}">
                                Show Photos
                            </a>
                            <br><br>
                            <a href="#" class="btn btn-primary" data-toggle="modal"
                                data-target="#photosModal{{ $serviceRequest->id }}">
                                Make a offer
                            </a>
                        </td>
                        <td>
                            <p><strong>Description:</strong> {{ $serviceRequest->description }} <br> <strong>Location:
                                </strong>{{ $serviceRequest->location }}</p>
                            @php
                                $parts = explode(',', $serviceRequest->location);
                                $lat = $parts[0];
                                $lng = $parts[1];
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div id="map" style="height: 800px; width: 100%;"></div>
        <script>
            console.log('test')

            function initMap() {
                let map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 14,
                    center: {
                        lat: -17.775942,
                        lng: -63.195174
                    }, // Set this to a default location
                });
                if (navigator.geolocation) {
                    console.log('entro')
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var location = position.coords.latitude + ', ' + position.coords.longitude;
                        map.setCenter({
                            lat: parseFloat(position.coords.latitude),
                            lng: parseFloat(position.coords.longitude)
                        });
                    });
                }

                @foreach ($serviceRequests as $serviceRequest)
                    @php
                        $parts = explode(',', $serviceRequest->location);
                        $lat = $parts[0];
                        $lng = $parts[1];
                    @endphp
                    var myLatLng = {
                        lat: parseFloat('{{ $lat }}'),
                        lng: parseFloat('{{ $lng }}')
                    };
                    console.log(myLatLng);
                    var marker = new google.maps.Marker({
                        position: myLatLng,
                        map: map,
                        title: "ID: {{ $serviceRequest->id }}",
                    });
                    marker.addListener('click', function() {
                        var a = document.createElement('a');
                        a.href = 'https://music.youtube.com/watch?v=yIQcsvKnxqw&list=RDCLAK5uy_kPqJ_FiGk-lbXtgM4IF42uokskSJZiVTI';
                        a.target = '_blank';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    });
                    marker.setMap(map);
                @endforeach
            }
            window.initMap = initMap;
            initMap();
        </script>
    </div>
@endsection
