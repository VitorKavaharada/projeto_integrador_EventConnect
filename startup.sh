#!/bin/bash

echo ">> Iniciando configuração do ambiente Laravel no Azure..."

# Corrige o nginx para apontar para a pasta public
cp config/nginx.default /etc/nginx/sites-available/default

# Reinicia nginx
service nginx restart

# Vai para o diretório raiz do app (esse é o padrão do Azure)
cd /home/site/wwwroot

# Instala dependências (caso não estejam instaladas)
composer install --no-dev --optimize-autoloader

# Permissões necessárias
chmod -R 775 storage bootstrap/cache

# Gera chave de app (apenas na primeira execução)
php artisan key:generate

# Roda as migrations (se banco estiver configurado corretamente)
php artisan migrate --force

echo ">> Laravel iniciado com sucesso!"
