@extends('layouts.app')

@section('content')

    @isset($rubros)
        @foreach ($rubros as $item)
            <publicaciones :rubro="{{ $item }}"></publicaciones>
        @endforeach
    @endisset
@endsection
