@extends('layouts.app')

@section('title', 'Daftar — ARQAM App')

@section('content')
@include('auth.login', ['mode' => 'register'])
@endsection
