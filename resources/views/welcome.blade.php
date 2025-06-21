<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>

        <!-- Fontes do Google -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
        
        <!-- CSS Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        
        <!-- CSS  -->
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

        <!-- js  -->
        <script src="{{ asset('js/scripts.js') }}" defer></script>

    </head>
    <body>
        <header>
                {{-- Não esquecer do @csrf --}}
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a href="/" class="navbar-brand">
                        <img class="logo" src="{{ asset('img/Logo_Teste.png') }}" alt="Logo">
                    </a>
                    <form action="/" method="GET" class="d-flex ms-3" style="width: 500px;">
                        <input type="text" name="research" class="form-control" placeholder="Pesquise por um jogo...">
                        <button type="submit" class="btn btn-outline-primary ms-2"><ion-icon name="search-outline"></ion-icon></button>
                    </form>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a href="/" class="nav-link">Início </a>
                            </li>
                            <li class="nav-item">
                                <a href="/evento/criacao" class="nav-link">Criar Jogos</a>
                            </li>
                            @auth
                            <li class="nav-item">
                                <a href="/dashboard" class="nav-link">Gerenciar Jogos</a>
                            </li>
                            <li class="nav-item">
                                 <form action="/logout" method="POST" style="display:inline;">{{-- display inline temporario --}}
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
                                <img src="{{ asset('img/carousel/acao-jogador.jpg') }}" class="d-block w-100" alt="Slide 1">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/carousel/jogadores-profissional.jpg') }}" class="d-block w-100" alt="Slide 2">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/carousel/jogadores2.jpg') }}" class="d-block w-100" alt="Slide 3">
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

      <footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Sobre o Event Connect -->
            <div class="col-md-3 col-sm-6 mb-4">
                <h5 class="footer-title">Event Connect</h5>
                <p class="footer-text">
                    O Event Connect é sua plataforma para criar e gerenciar jogos e eventos de forma prática e segura. Junte-se à nossa comunidade!
                </p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><ion-icon name="logo-facebook"></ion-icon></a>
                    <a href="#" class="social-icon"><ion-icon name="logo-twitter"></ion-icon></a>
                    <a href="#" class="social-icon"><ion-icon name="logo-instagram"></ion-icon></a>
                    <a href="#" class="social-icon"><ion-icon name="logo-linkedin"></ion-icon></a>
                </div>
            </div>

            <!-- Links Úteis -->
            <div class="col-md-3 col-sm-6 mb-4">
                <h5 class="footer-title">Links Úteis</h5>
                <ul class="footer-links">
                    <li><a href="/"><ion-icon name="home-outline"></ion-icon> Início</a></li>
                    <li><a href="/evento/criacao"><ion-icon name="add-circle-outline"></ion-icon> Criar Jogos</a></li>
                    <li><a href="/dashboard"><ion-icon name="apps-outline"></ion-icon> Gerenciar Jogos</a></li>
                    <li><a href="/termos"><ion-icon name="document-text-outline"></ion-icon> Termos de Uso</a></li>
                    <li><a href="/privacidade"><ion-icon name="shield-checkmark-outline"></ion-icon> Privacidade</a></li>
                </ul>
            </div>

            <!-- Contato -->
            <div class="col-md-3 col-sm-6 mb-4">
                <h5 class="footer-title">Contato</h5>
                <ul class="footer-links">
                    <li><ion-icon name="mail-outline"></ion-icon> contato@eventconnect.com</li>
                    <li><ion-icon name="call-outline"></ion-icon> (11) 1234-5678</li>
                    <li><ion-icon name="location-outline"></ion-icon> São Paulo, SP, Brasil</li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-md-3 col-sm-6 mb-4">
                <h5 class="footer-title">Newsletter</h5>
                <p class="footer-text">Inscreva-se para receber novidades e atualizações!</p>
                <form action="/newsletter" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Seu e-mail" required>
                        <button class="btn btn-primary" type="submit"><ion-icon name="paper-plane-outline"></ion-icon> Inscrever</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Event Connect © 2025. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>