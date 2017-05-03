<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Google MAP</title>

    <style>
        #map {
            height: 500px;
            width: 700px;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #pac-input {
            margin-top: 10px;
        }
    </style>
</head>

<body>

<h2>Distance from DevTech: <label id="res"></label></h2>
<input id="pac-input" class="controls" type="text" placeholder="Search Box">
<div id="map"></div>

<script>

    var markers = [];
    var lines = [];

    function clearMarkerAndLine() {
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
        markers = [];
        lines.forEach(function (line) {
            line.setMap(null);
        });
        lines = [];
    }

    function createMarker(map, searchBounds, devtech, location) {
        markers.push(new google.maps.Marker({
            map: map,
            title: "My Location",
            position: location
        }));

        var lineCoordinates = [
            devtech,
            {lat: location.lat(), lng: location.lng()}
        ];
        var aerialDistance = new google.maps.Polyline({
            path: lineCoordinates,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        aerialDistance.setMap(map);
        lines.push(aerialDistance);

        var newPosition = new google.maps.LatLng(location.lat(), location.lng());
        if (searchBounds.contains(newPosition)) {
            //calculates distance between two points in km's
            function calcDistance(p1, p2) {
                return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
            }

            document.getElementById('res').innerHTML = calcDistance(devtech, newPosition) + "km";
        } else {
            document.getElementById('res').innerHTML = '';
            alert('Out of bounds...')
        }
    }

    function initMap() {
        //begin map setup
        var devtech = new google.maps.LatLng(45.25345870690877, 19.845862984657288);

        var searchBounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(45.229425102968776, 19.774188995361328),
            new google.maps.LatLng(45.28029949181387, 19.882678985595703)
        );

        var map = new google.maps.Map(document.getElementById('map'));

        var marker = new google.maps.Marker({
            position: devtech,
            map: map,
            title: "DevTech DOO"
        });

        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

        var viewBounds = {
            north: 45.23747,
            south: 45.26756,
            east: 19.85218,
            west: 19.79433
        };

        map.fitBounds(viewBounds);
        //end map setup

        //Click on map
        google.maps.event.addListener(map, 'click', function (event) {
            clearMarkerAndLine();
            createMarker(map, searchBounds, devtech, event.latLng);
        });

        //Search address
        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();

            clearMarkerAndLine();
            createMarker(map, searchBounds, devtech, places[0].geometry.location);
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXSN5-KefqORJYNTpUxuIxERpAiiW4uek&callback=initMap&libraries=places,geometry"
        async
        defer></script>
</body>
</html>
