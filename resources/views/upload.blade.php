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
    <h1>It works!</h1>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">Choose file</label>
    </div>
@endsection