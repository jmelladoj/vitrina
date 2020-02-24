@extends('layouts.intranet')

@section('content')
    <home @isset($mensaje) mensaje="{{ $mensaje }}" @endisset></home>
@endsection
