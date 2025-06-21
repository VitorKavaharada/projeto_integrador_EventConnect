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