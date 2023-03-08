@extends('layouts.app')

@section('title')
    Página principal
@endsection

@section('content')    
    {{-- Componente de Laravel --}}
    {{-- Pasando variables --}}
    <x-listar-post :posts="$posts" />
@endsection