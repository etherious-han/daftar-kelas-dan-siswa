@extends('layouts.layout')

@section('konten')
<h1>Dashboard Siswa</h1>
<p>Selamat datang, {{ auth()->user()->name }}</p>
@endsection
