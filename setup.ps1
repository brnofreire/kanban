# Kanban Vox - Script de Setup Automático
# Execute este script no PowerShell para configurar o projeto

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "   KANBAN VOX - Setup Automático" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# 1. Instalar dependências do Composer
Write-Host "1. Instalando dependências do PHP (Composer)..." -ForegroundColor Yellow
composer install

if ($LASTEXITCODE -ne 0) {
    Write-Host "Erro ao instalar dependências do Composer!" -ForegroundColor Red
    exit 1
}

Write-Host "✓ Dependências do PHP instaladas com sucesso!" -ForegroundColor Green
Write-Host ""

# 2. Verificar se o banco de dados existe
Write-Host "2. Verificando banco de dados PostgreSQL..." -ForegroundColor Yellow
Write-Host "Certifique-se de que o PostgreSQL está rodando e o banco 'kanban_vox_tecnologia' existe." -ForegroundColor Yellow
Write-Host "Se não existir, crie com: psql -U root -c `"CREATE DATABASE kanban_vox_tecnologia;`"" -ForegroundColor Yellow
Write-Host ""

$continuar = Read-Host "Pressione ENTER para continuar ou CTRL+C para cancelar"

# 3. Executar migrations
Write-Host "3. Executando migrations..." -ForegroundColor Yellow
php artisan migrate --force

if ($LASTEXITCODE -ne 0) {
    Write-Host "Erro ao executar migrations!" -ForegroundColor Red
    Write-Host "Certifique-se de que o banco de dados existe e as credenciais estão corretas no arquivo .env" -ForegroundColor Red
    exit 1
}

Write-Host "✓ Migrations executadas com sucesso!" -ForegroundColor Green
Write-Host ""

# 4. Instalar Laravel UI
Write-Host "4. Instalando Laravel UI para autenticação..." -ForegroundColor Yellow
composer require laravel/ui

if ($LASTEXITCODE -ne 0) {
    Write-Host "Erro ao instalar Laravel UI!" -ForegroundColor Red
    exit 1
}

php artisan ui bootstrap --auth

Write-Host "✓ Laravel UI instalado com sucesso!" -ForegroundColor Green
Write-Host ""

# 5. Instalar dependências do Node.js
Write-Host "5. Instalando dependências do Node.js (NPM)..." -ForegroundColor Yellow
npm install

if ($LASTEXITCODE -ne 0) {
    Write-Host "Erro ao instalar dependências do NPM!" -ForegroundColor Red
    exit 1
}

Write-Host "✓ Dependências do Node.js instaladas com sucesso!" -ForegroundColor Green
Write-Host ""

# 6. Compilar assets
Write-Host "6. Compilando assets do frontend..." -ForegroundColor Yellow
npm run build

if ($LASTEXITCODE -ne 0) {
    Write-Host "Erro ao compilar assets!" -ForegroundColor Red
    exit 1
}

Write-Host "✓ Assets compilados com sucesso!" -ForegroundColor Green
Write-Host ""

# 7. Perguntar sobre dados de exemplo
Write-Host "7. Deseja criar dados de exemplo?" -ForegroundColor Yellow
$resposta = Read-Host "Digite 's' para SIM ou 'n' para NÃO (s/n)"

if ($resposta -eq 's' -or $resposta -eq 'S') {
    Write-Host "Criando dados de exemplo..." -ForegroundColor Yellow
    php artisan db:seed --class=KanbanSeeder

    Write-Host "✓ Dados de exemplo criados!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Credenciais de acesso:" -ForegroundColor Cyan
    Write-Host "  Email: demo@kanbanvox.com" -ForegroundColor White
    Write-Host "  Senha: password" -ForegroundColor White
}

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "   SETUP CONCLUÍDO COM SUCESSO!" -ForegroundColor Green
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Para iniciar o servidor de desenvolvimento, execute:" -ForegroundColor Yellow
Write-Host "  php artisan serve" -ForegroundColor White
Write-Host ""
Write-Host "Depois acesse: http://localhost:8000" -ForegroundColor Yellow
Write-Host ""
Write-Host "Pressione ENTER para iniciar o servidor agora..." -ForegroundColor Yellow
$iniciar = Read-Host

if ($iniciar -eq '' -or $iniciar -eq 's' -or $iniciar -eq 'S') {
    Write-Host ""
    Write-Host "Iniciando servidor..." -ForegroundColor Green
    Write-Host "Pressione CTRL+C para parar o servidor" -ForegroundColor Yellow
    Write-Host ""
    php artisan serve
}
