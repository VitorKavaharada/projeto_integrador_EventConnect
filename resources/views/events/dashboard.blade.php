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

                {{-- Jogos Criados --}}
                <div class="col-md-10 offset-md-1 dashboard-title-container">
                    <h1>Jogos Criados</h1>
                </div>
                <div class="col-md-10 offset-md-1 dashboard-events-container">
                    @if(count($createdEvents) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Horário</th>
                                    <th scope="col">Participantes</th>
                                    <th scope="col">Configurações da Partida</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($createdEvents as $event)
                                    <tr>
                                        <td scope="row">{{ $loop->index + 1 }}</td>
                                        <td><a href="/evento/{{ $event->id }}">{{ $event->headline }}</a></td>
                                        <td>{{ date('d/m/Y', strtotime($event->date_event)) }}</td>
                                        <td>{{ $event->time_event }}</td>
                                        <td>{{ count($event->users) }}</td>
                                        <td>
                                            <a href="/evento/editar/{{ $event->id }}" class="btn btn-info edit-btn">
                                                <ion-icon name="create-outline"></ion-icon> Editar
                                            </a>
                                            <form action="/evento/{{ $event->id }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete-btn">
                                                    <ion-icon name="trash-outline"></ion-icon> Excluir
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Você ainda não tem jogos criados, <a href="/evento/criacao">Criar jogo</a></p>
                    @endif
                </div>

                {{-- Jogos Inscritos --}}
                <div class="col-md-10 offset-md-1 dashboard-title-container">
                    <h1>Jogos Inscritos</h1>
                </div>
                <div class="col-md-10 offset-md-1 dashboard-events-container">
                    @if(count($participatedEvents) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Horário</th>
                                    <th scope="col">Participantes</th>
                                    <th scope="col">Configurações da Partida</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($participatedEvents as $event)
                                    <tr>
                                        <td scope="row">{{ $loop->index + 1 }}</td>
                                        <td><a href="/evento/{{ $event->id }}">{{ $event->headline }}</a></td>
                                        <td>{{ date('d/m/Y', strtotime($event->date_event)) }}</td>
                                        <td>{{ $event->time_event }}</td>
                                        <td>{{ count($event->users) }}</td>
                                        <td>
                                            <form action="/evento/cancelar/{{ $event->id }}" method="POST">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-danger delete-btn w-100">
                                                    <ion-icon name="trash-outline"></ion-icon> Sair do jogo
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Você ainda não está participando de nenhum jogo, <a href="/">Veja todos os jogos</a></p>
                    @endif
                </div>

                <!-- Histórico de Eventos -->
                <div class="col-md-10 offset-md-1 dashboard-title-container">
                    <h1>Histórico de Jogos</h1>
                </div>
                <div class="col-md-10 offset-md-1 dashboard-events-container">
                    @if(count($historicalEvents) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Horário</th>
                                    <th scope="col">Participantes</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historicalEvents as $event)
                                    <tr>
                                        <td scope="row">{{ $loop->index + 1 }}</td>
                                        <td><a href="/evento/{{ $event->id }}">{{ $event->headline }}</a></td>
                                        <td>{{ date('d/m/Y', strtotime($event->date_event)) }}</td>
                                        <td>{{ $event->time_event }}</td>
                                        <td>{{ count($event->users) }}</td>
                                        <td>Finalizado</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Você ainda não participou de nenhum jogo.</p>
                    @endif
                </div>

                <!-- Meus Ingressos -->
                <div class="col-md-10 offset-md-1 dashboard-title-container">
                    <h1>Meus Ingressos</h1>
                </div>
                <div class="col-md-10 offset-md-1 dashboard-events-container">
                    @if(count($tickets) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Evento</th>
                                    <th scope="col">Número do Ingresso</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Configurações da Partida</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                    <tr>
                                        <td scope="row">{{ $loop->index + 1 }}</td>
                                        <td>{{ $ticket->event_headline }}</td>
                                        <td>{{ $ticket->ticket_number }}</td>
                                        <td>{{ ucfirst($ticket->type) }}</td>
                                        <td>
                                            <a href="{{ route('ticket.show', $ticket->id) }}" class="btn btn-info">
                                                <ion-icon name="ticket-outline"></ion-icon> Ver Ingressos
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Você ainda não possui ingressos.</p>
                    @endif
                </div>

                <!-- Pagamentos Confirmados Pendentes de Ingresso -->
                @if (!empty($pendingPayments))
                    <div class="col-md-10 offset-md-1 dashboard-title-container">
                        <h1>Pagamentos Confirmados Pendentes de Ingresso</h1>
                    </div>
                    <div class="col-md-10 offset-md-1 dashboard-events-container">
                        @foreach ($pendingPayments as $event)
                            <div class="alert alert-warning">
                                <p>Pagamento confirmado para o evento "{{ $event->headline }}".</p>
                                <a href="{{ route('ticket.manual.form', $event->id) }}" class="btn btn-primary">Gerar Ingresso</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection