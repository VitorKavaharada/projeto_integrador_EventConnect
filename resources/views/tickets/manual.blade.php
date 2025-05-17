@extends('layouts.main')

@section('title', 'Gerar Ingresso Manualmente')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3 payment-container">
                <h1>Gerar Ingresso Manualmente</h1>
                <p>Evento: {{ $event->headline }}</p>
                <p>Após aprovar o pagamento no Dashboard do Stripe, clique no botão abaixo para gerar o ingresso.</p>

                <form action="{{ route('ticket.manual', $event->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Gerar Ingresso</button>
                </form>

                <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
            </div>
        </div>
    </div>
@endsection