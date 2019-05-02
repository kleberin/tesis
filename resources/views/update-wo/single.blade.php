@extends('layouts.app')

@section('content')
    <update-component></update-component>
@endsection

@section('styles')
    <style type="text/css">
        html, body, #app, .py-4 {
            height: 100%;
        }
        .py-4 {
            padding-bottom: 0 !important;
            padding-top: 0 !important;
        }
        .container-2 {
            margin-top: 20px;
        }
    </style>
@endsection