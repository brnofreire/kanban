@extends('layouts.app')

@section('title', 'Meus Quadros')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-columns"></i> Meus Quadros</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBoardModal">
            <i class="fas fa-plus"></i> Novo Quadro
        </button>
    </div>

    @if($boards->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-columns fa-5x text-muted mb-3"></i>
            <h4 class="text-muted">Você ainda não tem quadros</h4>
            <p class="text-muted">Crie seu primeiro quadro para começar a organizar suas tarefas!</p>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBoardModal">
                <i class="fas fa-plus"></i> Criar Primeiro Quadro
            </button>
        </div>
    @else
        <div class="row" id="boardsContainer">
            @foreach($boards as $board)
                <div class="col-md-4 col-lg-3 mb-4" data-board-id="{{ $board->id }}">
                    <div class="card board-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $board->title }}</h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($board->description, 80) }}
                            </p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-list"></i> {{ $board->categories->count() }} categorias
                                    <br>
                                    <i class="fas fa-tasks"></i> {{ $board->categories->sum(fn($c) => $c->tasks->count()) }} tarefas
                                </small>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent d-flex justify-content-between">
                            <a href="{{ route('boards.show', $board) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Abrir
                            </a>
                            <div>
                                <button class="btn btn-sm btn-outline-secondary edit-board-btn"
                                        data-board-id="{{ $board->id }}"
                                        data-board-title="{{ $board->title }}"
                                        data-board-description="{{ $board->description }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-board-btn"
                                        data-board-id="{{ $board->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Create Board Modal -->
<div class="modal fade" id="createBoardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Novo Quadro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createBoardForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="board_title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="board_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="board_description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="board_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar Quadro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Board Modal -->
<div class="modal fade" id="editBoardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Quadro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editBoardForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_board_id" name="board_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_board_title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit_board_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_board_description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="edit_board_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Create Board
    $('#createBoardForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('boards.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                showToast('Quadro criado com sucesso!');
                location.reload();
            },
            error: function(xhr) {
                showToast('Erro ao criar quadro', 'error');
            }
        });
    });

    // Edit Board - Open Modal
    $('.edit-board-btn').on('click', function() {
        const boardId = $(this).data('board-id');
        const boardTitle = $(this).data('board-title');
        const boardDescription = $(this).data('board-description');

        $('#edit_board_id').val(boardId);
        $('#edit_board_title').val(boardTitle);
        $('#edit_board_description').val(boardDescription);

        $('#editBoardModal').modal('show');
    });

    // Edit Board - Submit
    $('#editBoardForm').on('submit', function(e) {
        e.preventDefault();

        const boardId = $('#edit_board_id').val();

        $.ajax({
            url: `/boards/${boardId}`,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                showToast('Quadro atualizado com sucesso!');
                location.reload();
            },
            error: function(xhr) {
                showToast('Erro ao atualizar quadro', 'error');
            }
        });
    });

    // Delete Board
    $('.delete-board-btn').on('click', function() {
        const boardId = $(this).data('board-id');

        if (confirm('Tem certeza que deseja excluir este quadro? Todas as categorias e tarefas serão removidas.')) {
            $.ajax({
                url: `/boards/${boardId}`,
                method: 'DELETE',
                success: function(response) {
                    showToast('Quadro excluído com sucesso!');
                    $(`[data-board-id="${boardId}"]`).fadeOut(300, function() {
                        $(this).remove();

                        if ($('#boardsContainer .col-md-4').length === 0) {
                            location.reload();
                        }
                    });
                },
                error: function(xhr) {
                    showToast('Erro ao excluir quadro', 'error');
                }
            });
        }
    });
});
</script>
@endsection
