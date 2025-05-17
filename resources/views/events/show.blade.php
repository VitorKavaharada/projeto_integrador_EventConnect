@extends('layouts.main')

@section('title', $event->headline)

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endpush

<div class="col-md-10 offset-md-1">
    <div class="row">
        <div id="image-container" class="col-md-6">
            <img src="{{ asset('img/events/' . $event->picture) }}" class="img-fluid" alt="{{ $event->headline }}">
        </div>
        <div id="info-container" class="col-md-6">
            <h1>{{ $event->headline }}</h1>
            <p class="event-town">
                <ion-icon name="navigate-outline"></ion-icon>
                @if($event->address)
                    {{ $event->address->street }}, {{ $event->address->addressNumber }} - 
                    {{ $event->address->neighborhood }}, {{ $event->address->municipality }} - {{ $event->address->state }}
                @endif
            </p>
            <p> 
                <ion-icon name="time-outline"></ion-icon>
                {{ $event->time_event ? date('H:i', strtotime($event->time_event)) : 'Horário não definido' }}
            </p>
            <p>
                <ion-icon name="people-outline"></ion-icon>
                Participantes: {{ count($event->users) }} / {{ $event->participant_limit ?? 'Sem limite' }}
            </p>
            <p>
                <ion-icon name="cash-outline"></ion-icon>
                Preço: {{ $event->price == 0 ? 'Gratuito' : 'R$ ' . number_format($event->price, 2, ',', '.') }}
            </p>
            <p class="event-owner">
                <ion-icon name="man-outline"></ion-icon>
                {{ $eventOrganizer['name'] }}
            </p>
            @if($event->is_expired)
                <p class="event-expired-msg text-danger">Esta partida já expirou e não aceita novas inscrições.</p>
            @elseif($event->participant_limit && count($event->users) >= $event->participant_limit)
                <p class="event-full-msg">Esta partida já atingiu a capacidade máxima de participantes.</p>
            @elseif(!$isUserRegistered)
                <form action="/evento/presenca/{{$event->id}}" method="POST">
                    @csrf
                    <a href="/evento/presenca/{{$event->id}}"  
                       class="btn btn-primary" 
                       id="event-submit"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ $event->price == 0 ? 'Confirmar presença' : 'Pagar ingresso' }}
                    </a>
                </form>
            @else
                <p class="event-confirm-msg">Você já se inscreveu nessa partida</p>
            @endif

            <div class="event-products">
                <h3>O local conta com:</h3>
                <ul>
                    @foreach($event->products as $product)
                        <li>{{ $product->product_name }}</li>
                    @endforeach
                    @if($event->custom_product)
                        <li>{{ $event->custom_product }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="col-md-12" id="description-container">
            <h3>Sobre a partida:</h3>
            <p class="event-description">{{ $event->details }}</p>
        </div>
    </div>
</div>
<div class="event-participants">
    <h3>Lista de Participantes:</h3>
    @php
        $confirmedParticipants = $event->users->filter(function($user) use ($event) {
            return $event->tickets()->where('user_id', $user->id)->exists();
        });
    @endphp
    @if(count($confirmedParticipants) > 0)
        <ul>
            @foreach($confirmedParticipants as $participant)
                <li>{{ $participant->name }}</li>
            @endforeach
        </ul>
    @else
        <p>Nenhum participante confirmado até agora.</p>
    @endif
</div>

@endsection