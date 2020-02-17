@extends('layouts.app')

@section('content')

    @isset($rubros)
        <resultados :comuna_id="{{ $comuna->id }}" :rubros="{{ $rubros }}"></resultados>
    @endisset
@endsection
