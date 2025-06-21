<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>

        <!-- Fontes do Google -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        
        <!-- CSS Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        
        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

        <!-- js -->
        <script src="{{ asset('js/scripts.js') }}" defer></script>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid px-4">
                    <a href="/" class="navbar-brand order-lg-1">
                        <img class="logo" src="{{ asset('img/Logo_Teste.png') }}" alt="Logo">
                    </a>
                    <div class="d-flex align-items-center flex-grow-1 ms-3 search-form order-lg-2">
                        <form action="/" method="GET" class="w-100">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="research" class="form-control rounded-pill" placeholder="Pesquise por um jogo...">
                                <button type="submit" class="btn btn-outline-primary ms-2 rounded-pill"><ion-icon name="search-outline"></ion-icon></button>
                            </div>
                        </form>
                    </div>
                    <button class="navbar-toggler order-lg-4 order-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse order-lg-3 order-4" id="navbarNav">
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="nav-item">
                                <a href="/" class="nav-link">Início</a>
                            </li>
                            <li class="nav-item">
                                <a href="/evento/criacao" class="nav-link">Criar Jogos</a>
                            </li>
                            @auth
                            <li class="nav-item">
                                <a href="/dashboard" class="nav-link">Gerenciar Jogos</a>
                            </li>
                            <li class="nav-item">
                                <form action="/logout" method="POST" style="display:inline;">
                                    @csrf
                                    <a href="/logout" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">Sair</a>
                                </form>
                            </li>
                            @endauth
                            @guest
                            <li class="nav-item">
                                <a href="/login" class="nav-link">Entrar</a>
                            </li>
                            <li class="nav-item">
                                <a href="/register" class="nav-link">Cadastrar</a>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <div class="container-fluid">
                <div class="row">
                    @if(session('msg'))
                        <p class="msg">{{ session('msg') }}</p>
                    @endif
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('img/carousel/jogopes_hd.jpeg') }}" class="d-block w-100" alt="Slide 1">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/carousel/estadio.jpeg') }}" class="d-block w-100" alt="Slide 2">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/carousel/estadio_2.png') }}" class="d-block w-100" alt="Slide 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div id="events-container" class="col-md-12">
                        @if($research)
                            <h2>Buscando por: {{$research}}</h2>
                        @else
                            <h2>Próximos Jogos</h2>
                            <p class="subtitle">Veja as partidas dos próximos dias</p>
                        @endif
                        <div id="cards-container" class="row">
                            @foreach($events as $event)
                                <div class="card col-md-3">
                                    <img src="{{ asset('img/events/' . $event->picture) }}" alt="{{ $event->headline }}">
                                    <div class="card-body">
                                        <p class="card-date">{{date('d/m/Y', strtotime($event->date_event))}}</p>
                                        <h5 class="card-title">{{ $event->headline }}</h5>
                                        <p class="card-participants">{{count($event->users)}} Participantes</p>
                                        <a href="/evento/{{ $event->id }}" class="btn btn-primary">Saber mais</a>
                                    </div>
                                </div>
                            @endforeach
                            @if(count($events) == 0 && $research)
                                <p>Não foi possível encontrar nenhuma partida com "{{$research}}" <a href="/">Ver todos</a></p>
                            @elseif(count($events) == 0)
                                <p>Não há partidas disponíveis</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        @include('partials.footer')

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>