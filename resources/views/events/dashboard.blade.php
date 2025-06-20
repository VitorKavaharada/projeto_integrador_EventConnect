@extends('layouts.main')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1 dashboard-container">
                @if (session('msg'))
                    <div class="alert alert-success">
                        {{ session('msg') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="dashboard-title-container">
                    <h1>Bem-vindo ao Dashboard</h1>
                </div>

                <div class="dashboard-menu">
                    <a href="{{ route('dashboard.user-events') }}" class="menu-item">
                        <h2>Meus Eventos</h2>
                        <p>Veja seus ingressos, jogos inscritos e histórico de jogos.</p>
                    </a>
                    <a href="{{ route('dashboard.created-events') }}" class="menu-item">
                        <h2>Jogos Criados</h2>
                        <p>Gerencie os jogos que você criou e pagamentos pendentes.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection