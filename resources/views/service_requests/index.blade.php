@extends('layouts.app')
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLiZOnEOdbn1pP9n96DFUzT1WUXszhDP8&callback=initMap"></script>
@section('content')
    <div class="container">
        <div id="overlay"
            style="display: none; position: fixed; width: 100%; height: 100%; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 2; cursor: pointer;">
        </div>
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
                            <a href="javascript:void(0);" onclick="window.open('{{ route('propositions.create2', ['id' => $serviceRequest->id]) }}', 'newwindow', 'width=300,height=250');" class="btn btn-primary">
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
                        var url = '{{ route('propositions.create2', ['id' => $serviceRequest->id]) }}';
                        var newWindow = window.open(
                            url, 'newwindow',
                            'width=300,height=250');
                        document.getElementById('overlay').style.display = 'block';

                        var timer = setInterval(function() {
                            if (newWindow.closed) {
                                clearInterval(timer);
                                document.getElementById('overlay').style.display = 'none';
                            }
                        }, 500);
                    });
                    marker.setMap(map);
                @endforeach
            }
            window.initMap = initMap;
            initMap();
        </script>
    </div>
@endsection
