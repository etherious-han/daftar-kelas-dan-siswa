@extends('layouts.layout')

@section('konten')
<h1>Dashboard Admin</h1>
<p>Selamat datang, {{ auth()->user()->name }}</p>
@endsection
