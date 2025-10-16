@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="jumbotron bg-light p-5 rounded-3">
                <h1 class="display-4">Bem-vindo ao Kanban Vox! 👋</h1>
                <p class="lead">Sistema de gerenciamento de tarefas estilo Trello desenvolvido com Laravel 11.</p>
                <hr class="my-4">
                <p>Organize suas tarefas em quadros personalizados, categorias e mova-as facilmente com drag-and-drop!</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    @auth
                        <a class="btn btn-primary btn-lg" href="{{ route('boards.index') }}" role="button">
                            <i class="fas fa-columns"></i> Meus Quadros
                        </a>
                    @else
                        <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a class="btn btn-outline-secondary btn-lg" href="{{ route('register') }}" role="button">
                            <i class="fas fa-user-plus"></i> Registrar
                        </a>
                    @endauth
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-columns fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Múltiplos Quadros</h5>
                            <p class="card-text">Crie quantos quadros precisar para organizar diferentes projetos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-list fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Categorias Flexíveis</h5>
                            <p class="card-text">Organize tarefas em categorias personalizadas como To Do, In Progress, Done.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-hand-pointer fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Drag & Drop</h5>
                            <p class="card-text">Mova tarefas entre categorias facilmente com arrastar e soltar.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info mt-4" role="alert">
                <h5 class="alert-heading"><i class="fas fa-info-circle"></i> Tecnologias Utilizadas</h5>
                <ul class="mb-0">
                    <li><strong>Backend:</strong> Laravel 11, PHP 8.2+, PostgreSQL</li>
                    <li><strong>Frontend:</strong> Bootstrap 5, jQuery, jQuery UI</li>
                    <li><strong>Recursos:</strong> AJAX, Drag-and-Drop, Autenticação, Policies</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
