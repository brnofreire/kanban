# Guia de Testes - Kanban Vox

## ✅ O que foi corrigido:

1. **Layout corrigido** - Bootstrap 5 + jQuery + jQuery UI funcionando
2. **Rotas limpas** - Removido duplicação de rotas Auth
3. **Cache limpo** - Config e rotas atualizadas
4. **JavaScript funcional** - AJAX configurado corretamente

## 🧪 Como testar a aplicação:

### 1. Acesse a aplicação
```
http://localhost:8000
```

### 2. Faça login com as credenciais:
- **Email:** admin@admin.com
- **Senha:** 123456

### 3. Teste criar um quadro:
1. Clique em "Novo Quadro"
2. Preencha o título (ex: "Meu Projeto")
3. Clique em "Criar Quadro"
4. Se aparecer algum erro no navegador, pressione **F12** e veja o Console

### 4. Teste as categorias (dentro de um quadro):
1. Abra um quadro
2. Clique em "Nova Categoria"
3. Digite um nome (ex: "To Do", "In Progress", "Done")
4. As categorias devem aparecer **lado a lado** (estilo Trello)

### 5. Teste as tarefas:
1. Dentro de uma categoria, clique em "Adicionar Tarefa"
2. Preencha título e descrição
3. Clique em "Salvar"
4. Teste arrastar a tarefa entre categorias

## 🐛 Se algo não funcionar:

### Problema: Modal não abre ao clicar em "Novo Quadro"

**Solução:**
1. Pressione **F12** no navegador
2. Vá na aba **Console**
3. Veja se há erros de JavaScript
4. Me envie a mensagem de erro

### Problema: "Nenhuma categoria criada ainda"

**Isso é normal!** Você precisa:
1. Criar categorias clicando em "Nova Categoria"
2. Cada categoria ficará lado a lado (estilo Trello)

### Problema: Categorias não aparecem lado a lado

Verifique se o CSS está carregado:
1. Pressione **F12**
2. Vá na aba **Network**
3. Recarregue a página
4. Verifique se Bootstrap está carregando (deve aparecer verde/200)

## 📸 Como deve ficar:

### Tela de Quadros:
```
┌────────────────┐  ┌────────────────┐  ┌────────────────┐
│  Projeto 1     │  │  Projeto 2     │  │  Projeto 3     │
│  3 categorias  │  │  5 categorias  │  │  2 categorias  │
│  [Abrir]       │  │  [Abrir]       │  │  [Abrir]       │
└────────────────┘  └────────────────┘  └────────────────┘
```

### Dentro do Quadro (estilo Trello):
```
┌─────────────┐  ┌─────────────┐  ┌─────────────┐
│   To Do     │  │ In Progress │  │    Done     │
├─────────────┤  ├─────────────┤  ├─────────────┤
│ ☐ Tarefa 1  │  │ ☐ Tarefa 3  │  │ ☑ Tarefa 5  │
│ ☐ Tarefa 2  │  │ ☐ Tarefa 4  │  │ ☑ Tarefa 6  │
│ [+ Adicionar│  │ [+ Adicionar│  │ [+ Adicionar│
└─────────────┘  └─────────────┘  └─────────────┘
```

## 🎯 Funcionalidades que devem funcionar:

✅ Login/Logout
✅ Criar/Editar/Excluir Quadros
✅ Criar/Editar/Excluir Categorias
✅ Criar/Editar/Excluir Tarefas
✅ Arrastar e soltar tarefas entre categorias
✅ Notificações toast (mensagens de sucesso/erro)
✅ Atualização dinâmica sem reload da página

## 🔧 Comandos úteis:

### Reiniciar do zero:
```powershell
php artisan migrate:fresh
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=KanbanSeeder
```

### Limpar cache:
```powershell
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Ver logs de erro:
```powershell
Get-Content storage\logs\laravel.log -Tail 50
```

---

**Teste agora e me avise se aparecer algum erro!** 😊
