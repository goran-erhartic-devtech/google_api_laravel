<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Google MAP</title>

    <link rel="stylesheet" href="{{URL::asset('/css/googleMap.css')}}">
</head>

<body>

<h2>Distance from DevTech: <label id="res"></label></h2>
<input id="pac-input" class="controls" type="text" placeholder="Search Box">
<div id="map"></div>

<script type="text/javascript" src="js/googleMap.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXSN5-KefqORJYNTpUxuIxERpAiiW4uek&callback=initMap&libraries=places,geometry"
        async
        defer></script>
</body>
</html>
