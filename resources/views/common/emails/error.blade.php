@extends('common.emails.layout')
@section('preview_text')
    {!! $error !!}
@endsection

@section('content')
    <h3>{{ $store }}</h3>
    <br>
    <div style="margin: 0;"><strong>Url</strong> {!! $url !!}</div>
    <br>
    <div style="margin: 0;"><strong>Error</strong> {!! $error !!}</div>
    <br>
    <div style="margin: 0;"><strong>File</strong> {!! $file !!}</div>
    <br>
    <div style="margin: 0;"><strong>Line</strong> {!! $line !!}</div>
    <br>
    {{ $trace }}
@endsection

