@extends('layouts/dashboardTemplate')

@section('title', 'Dashboard doctor')

@section('content')
    {{-- $_SESSION['username'] --}}
    <h1 class="mt-4">Bienvenido, </h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
@endsection
