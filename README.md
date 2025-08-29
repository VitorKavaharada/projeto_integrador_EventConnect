# EventConnect - Projeto Integrador

Repositório destinado à colaboração em equipe para gerenciar eventos esportivos sobre o projeto integrador do primeiro semestre de 2025.

---

##  Funcionalidades

- **Criação e Edição de Partidas**  
  Permite que usuários criem e editem jogos com detalhes como data, horário, local e infraestrutura associados.

- **Gestão de Ingressos**  
  Geração manual de ingressos após confirmação de pagamento, com QR codes para validação.

- **Integração com Stripe**  
  Simulação do processamento de pagamentos com validação de *PaymentIntents* no ambiente SandBox.

- **Dashboard Personalizado**  
  Interface para visualizar partidas criadas, inscritos, históricos e ingressos gerados.

- **Controle de Acesso**  
  Restrição de acesso a usuários autenticados.

---

##  Tecnologias Utilizadas

### Backend
- PHP 8.2.12
- Laravel 11.43.2

### Frontend
- HTML, CSS, JavaScript
- [QRCode.js](https://github.com/davidshimjs/qrcodejs) para geração de QR codes

### Banco de Dados
- MySQL 10.4.32-MariaDB
- Gerenciado via phpMyAdmin 5.2.1 

### Pagamentos
- Stripe API (ambiente SandBox)

### Outras Bibliotecas
- Carbon para manipulação de datas
- Laravel Authentication (Fortify, Jetstream, Sanctum)

### Ferramentas de Desenvolvimento
- Composer para gerenciamento de dependências

---

## Pré-requisitos

- PHP 8.2.12 ou superior  
- Composer  
- Node.js 16.x ou superior  
- MySQL 10.4.32-MariaDB ou compatível  
- Conta Stripe (ambiente SandBox)  
- Git  

---

## Instalação

1. **Instale as dependências do PHP:**
   ```bash
   composer install

2. **Instale as dependências do frontend:**
   ```bash
   npm install
   npm run build

3. **Configure as chaves da API Stripe no arquivo `.env`:**
   ```env
   STRIPE_KEY=sua_chave_publica
   STRIPE_SECRET=sua_chave_secreta
