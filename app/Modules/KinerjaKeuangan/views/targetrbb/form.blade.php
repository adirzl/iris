@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'target-rbb.upload';
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Sumber Data')
@section('content')

@endsection