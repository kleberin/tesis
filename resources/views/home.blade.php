@extends('layouts.app')

@section('styles')
    <style>
        html, body, #app, .py-4, #wrapper, #map {
            height: 100%;
        }
        .py-4 {
            padding-bottom: 0 !important;
            padding-top: 0 !important;
        }
        #wrapper {
            position: relative;
        }
        .floating {
            position: absolute;
            top: 10px;
        }
    </style>
@endsection

@section('content')
    <div id="wrapper">
        <div id="map"></div>
        <search-component title="{{ __("Búsqueda")}}" class="floating">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            You are logged in!
        </search-component>
    </div>
@endsection

@section('bottom-scripts')
    <script type="text/javascript">
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -0.202499, lng: -78.499637},
          zoom: 12,
          fullscreenControl: false,
          mapTypeControl: false,
          streetViewControl: false
        });
      }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMeWeb5KUZk37Q1Puu2s_1qrka2B5CLhA&callback=initMap"></script>
@endsection