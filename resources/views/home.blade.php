@extends('layouts.app')

@section('styles')
    <style type="text/css">
        html, body, #app, .py-4 {
            height: 100%;
        }
        .py-4 {
            padding-bottom: 0 !important;
            padding-top: 0 !important;
        }
    </style>
@endsection

@section('content')
    <gmap-component></gmap-component>
@endsection