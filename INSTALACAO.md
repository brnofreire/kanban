# INSTRUÇÕES DE INSTALAÇÃO RÁPIDA

## Opção 1: Setup Automático (Recomendado)

Execute o script PowerShell:
```powershell
.\setup.ps1
```

## Opção 2: Setup Manual

### Passo 1: Instalar dependências
```powershell
composer install
```

### Passo 2: Criar banco de dados
```powershell
# Conecte ao PostgreSQL e execute:
psql -U root -c "CREATE DATABASE kanban_vox_tecnologia;"
```

### Passo 3: Executar migrations
```powershell
php artisan migrate
```

### Passo 4: Instalar Laravel UI
```powershell
composer require laravel/ui
php artisan ui bootstrap --auth
```

### Passo 5: Instalar dependências frontend
```powershell
npm install
npm run build
```

### Passo 6: (Opcional) Criar dados de exemplo
```powershell
php artisan db:seed --class=KanbanSeeder
```

Credenciais de teste:
- Email: demo@kanbanvox.com
- Senha: password

### Passo 7: Iniciar servidor
```powershell
php artisan serve
```

Acesse: http://localhost:8000

---

## Resolução de Problemas Comuns

### Erro: "could not find driver"
Certifique-se de que a extensão pdo_pgsql está habilitada no php.ini:
```
extension=pdo_pgsql
extension=pgsql
```

### Erro: "SQLSTATE[08006] [7]"
- Verifique se o PostgreSQL está rodando
- Confirme as credenciais no arquivo .env
- Certifique-se de que o banco de dados existe

### Erro nas views de autenticação
Execute novamente:
```powershell
php artisan ui bootstrap --auth
```

### Assets não carregam
Execute:
```powershell
npm run build
```

---

## Estrutura Criada

✅ Models: Board, Category, Task, User
✅ Controllers: BoardController, CategoryController, TaskController
✅ Views: Layout, Boards (index/show), Auth (login/register)
✅ Migrations: Todas as tabelas necessárias
✅ Policies: BoardPolicy para controle de acesso
✅ Rotas: Web routes com middleware de autenticação
✅ JavaScript: jQuery com drag-and-drop (jQuery UI)
✅ CSS: Bootstrap 5 responsivo

---

## Funcionalidades Implementadas

1. ✅ Sistema de autenticação completo (Laravel UI)
2. ✅ CRUD de Quadros (Boards)
3. ✅ CRUD de Categorias
4. ✅ CRUD de Tarefas
5. ✅ Drag and drop entre categorias
6. ✅ Controle de permissões por usuário
7. ✅ Interface responsiva (Bootstrap 5)
8. ✅ Operações AJAX sem reload
9. ✅ Notificações toast
10. ✅ PostgreSQL como banco de dados

---

## Testando a Aplicação

1. Registre um novo usuário ou use as credenciais de demo
2. Crie um novo quadro
3. Adicione categorias (ex: To Do, In Progress, Done)
4. Crie tarefas em cada categoria
5. Arraste e solte as tarefas entre categorias
6. Edite e exclua tarefas/categorias/quadros

---

Para mais detalhes, consulte README_KANBAN.md
