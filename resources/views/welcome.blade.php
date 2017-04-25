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
    </style>
</head>

<body>

<h2>Distance from DevTech: <label id="res"></label></h2>

<div id="map"></div>
<script>
    var markers = [];
    var lines = [];
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 45.2538935, lng: 19.8426667}
        });
        var marker = new google.maps.Marker({
            position: {lat: 45.2538935, lng: 19.8426667},
            map: map,
            title: "DevTech DOO"
        });

        var bounds = {
            north: 45.23747,
            south: 45.26756,
            east: 19.85218,
            west: 19.79433
        };

        map.fitBounds(bounds);

        var bounds2 = new google.maps.LatLngBounds(
            new google.maps.LatLng(45.229425102968776, 19.774188995361328),
            new google.maps.LatLng(45.28029949181387, 19.882678985595703));

        google.maps.event.addListener(map, 'click', function (event) {
            var opa = function () {
                var marker2 = new google.maps.Marker({
                    position: event.latLng,
                    map: map,
                    title: "My Location"
                });
                markers.push(marker2);

                var lineCoordinates = [
                    {lat: 45.2538935, lng: 19.8426667},
                    {lat: event.latLng.lat(), lng: event.latLng.lng()}
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
            };

            if (markers.length === 0) {
                opa();
            } else {
                markers[markers.length - 1].setMap(null);
                lines[lines.length -1].setMap(null);

                opa();
            }

            var devtech = new google.maps.LatLng(45.2538935, 19.8426667);
            var newPosition = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());


            if (bounds2.contains(newPosition)) {
                //calculates distance between two points in km's
                function calcDistance(p1, p2) {
                    return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
                }

                document.getElementById('res').innerHTML = calcDistance(devtech, newPosition) + "km";
            } else {
                document.getElementById('res').innerHTML = '';
                alert('Out of bounds...')
            }


        });

    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXSN5-KefqORJYNTpUxuIxERpAiiW4uek&callback=initMap&libraries=geometry"
        async
        defer></script>
</body>
</html>