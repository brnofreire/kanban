@extends('layouts.app')

@section('title', $board->title)

@section('content')
<div class="container-fluid px-4">
    <!-- Board Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('boards.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <h2>{{ $board->title }}</h2>
            @if($board->description)
                <p class="text-muted">{{ $board->description }}</p>
            @endif
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
            <i class="fas fa-plus"></i> Nova Categoria
        </button>
    </div>

    <!-- Kanban Board -->
    <div class="kanban-board" id="kanbanBoard">
        @forelse($board->categories as $category)
            <div class="category-wrapper" data-category-id="{{ $category->id }}">
                <div class="category-column" data-category-id="{{ $category->id }}">
                    <!-- Category Header -->
                    <div class="category-header">
                        <h5 class="mb-0 category-title">{{ $category->title }}</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-sm btn-outline-secondary edit-category-btn"
                                    data-category-id="{{ $category->id }}"
                                    data-category-title="{{ $category->title }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-category-btn"
                                    data-category-id="{{ $category->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tasks Container -->
                    <div class="tasks-container" data-category-id="{{ $category->id }}">
                        @foreach($category->tasks as $task)
                            <div class="task-card" data-task-id="{{ $task->id }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <strong class="task-title">{{ $task->title }}</strong>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-sm btn-link text-secondary p-0 px-1 edit-task-btn"
                                                data-task-id="{{ $task->id }}"
                                                data-task-title="{{ $task->title }}"
                                                data-task-description="{{ $task->description }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link text-danger p-0 px-1 delete-task-btn"
                                                data-task-id="{{ $task->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @if($task->description)
                                    <p class="text-muted small mb-0 task-description">{{ Str::limit($task->description, 100) }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Add Task Button -->
                    <button class="btn btn-sm btn-outline-primary w-100 mt-2 add-task-btn"
                            data-category-id="{{ $category->id }}">
                        <i class="fas fa-plus"></i> Adicionar Tarefa
                    </button>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Nenhuma categoria criada ainda. Crie sua primeira categoria para começar!
            </div>
        @endforelse
    </div>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Nova Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createCategoryForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category_title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="category_title" name="title" required
                               placeholder="Ex: To Do, Em Progresso, Concluído">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar Categoria</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCategoryForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_category_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_category_title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit_category_title" name="title" required>
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

<!-- Create/Edit Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalTitle"><i class="fas fa-plus"></i> Nova Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="taskForm">
                @csrf
                <input type="hidden" id="task_id">
                <input type="hidden" id="task_category_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="task_title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="task_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="task_description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="task_description" name="description" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const boardId = {{ $board->id }};

$(document).ready(function() {
    // Initialize sortable for tasks (drag and drop)
    initializeSortable();

    // Create Category
    $('#createCategoryForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: `/boards/${boardId}/categories`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                showToast('Categoria criada com sucesso!');
                location.reload();
            },
            error: function(xhr) {
                showToast('Erro ao criar categoria', 'error');
            }
        });
    });

    // Edit Category - Open Modal
    $(document).on('click', '.edit-category-btn', function() {
        const categoryId = $(this).data('category-id');
        const categoryTitle = $(this).data('category-title');

        $('#edit_category_id').val(categoryId);
        $('#edit_category_title').val(categoryTitle);

        $('#editCategoryModal').modal('show');
    });

    // Edit Category - Submit
    $('#editCategoryForm').on('submit', function(e) {
        e.preventDefault();

        const categoryId = $('#edit_category_id').val();

        $.ajax({
            url: `/categories/${categoryId}`,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                showToast('Categoria atualizada com sucesso!');
                $(`.category-column[data-category-id="${categoryId}"] .category-title`).text(response.category.title);
                $('#editCategoryModal').modal('hide');
            },
            error: function(xhr) {
                showToast('Erro ao atualizar categoria', 'error');
            }
        });
    });

    // Delete Category
    $(document).on('click', '.delete-category-btn', function() {
        const categoryId = $(this).data('category-id');

        if (confirm('Tem certeza que deseja excluir esta categoria? Todas as tarefas serão removidas.')) {
            $.ajax({
                url: `/categories/${categoryId}`,
                method: 'DELETE',
                success: function(response) {
                    showToast('Categoria excluída com sucesso!');
                    $(`.category-wrapper[data-category-id="${categoryId}"]`).fadeOut(300, function() {
                        $(this).remove();
                    });
                },
                error: function(xhr) {
                    showToast('Erro ao excluir categoria', 'error');
                }
            });
        }
    });

    // Add Task - Open Modal
    $(document).on('click', '.add-task-btn', function() {
        const categoryId = $(this).data('category-id');

        $('#taskModalTitle').html('<i class="fas fa-plus"></i> Nova Tarefa');
        $('#task_id').val('');
        $('#task_category_id').val(categoryId);
        $('#task_title').val('');
        $('#task_description').val('');

        $('#taskModal').modal('show');
    });

    // Edit Task - Open Modal
    $(document).on('click', '.edit-task-btn', function() {
        const taskId = $(this).data('task-id');
        const taskTitle = $(this).data('task-title');
        const taskDescription = $(this).data('task-description');

        $('#taskModalTitle').html('<i class="fas fa-edit"></i> Editar Tarefa');
        $('#task_id').val(taskId);
        $('#task_title').val(taskTitle);
        $('#task_description').val(taskDescription);

        $('#taskModal').modal('show');
    });

    // Task Form Submit (Create or Update)
    $('#taskForm').on('submit', function(e) {
        e.preventDefault();

        const taskId = $('#task_id').val();
        const categoryId = $('#task_category_id').val();
        const isEdit = taskId !== '';

        const url = isEdit ? `/tasks/${taskId}` : `/categories/${categoryId}/tasks`;
        const method = isEdit ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            success: function(response) {
                showToast(isEdit ? 'Tarefa atualizada com sucesso!' : 'Tarefa criada com sucesso!');
                $('#taskModal').modal('hide');

                if (isEdit) {
                    // Update existing task card
                    const taskCard = $(`.task-card[data-task-id="${taskId}"]`);
                    taskCard.find('.task-title').text(response.task.title);
                    taskCard.find('.task-description').text(response.task.description ? response.task.description.substring(0, 100) : '');
                    taskCard.find('.edit-task-btn').data('task-title', response.task.title);
                    taskCard.find('.edit-task-btn').data('task-description', response.task.description);
                } else {
                    location.reload();
                }
            },
            error: function(xhr) {
                showToast('Erro ao salvar tarefa', 'error');
            }
        });
    });

    // Delete Task
    $(document).on('click', '.delete-task-btn', function() {
        const taskId = $(this).data('task-id');

        if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
            $.ajax({
                url: `/tasks/${taskId}`,
                method: 'DELETE',
                success: function(response) {
                    showToast('Tarefa excluída com sucesso!');
                    $(`.task-card[data-task-id="${taskId}"]`).fadeOut(300, function() {
                        $(this).remove();
                    });
                },
                error: function(xhr) {
                    showToast('Erro ao excluir tarefa', 'error');
                }
            });
        }
    });
});

// Initialize sortable (drag and drop)
function initializeSortable() {
    $('.tasks-container').sortable({
        connectWith: '.tasks-container',
        placeholder: 'sortable-placeholder',
        cursor: 'move',
        opacity: 0.8,
        tolerance: 'pointer',
        update: function(event, ui) {
            // Only trigger if item was moved to this list
            if (this === ui.item.parent()[0]) {
                const taskId = ui.item.data('task-id');
                const newCategoryId = $(this).data('category-id');
                const newPosition = ui.item.index();

                // Update task position via AJAX
                $.ajax({
                    url: `/tasks/${taskId}/move`,
                    method: 'POST',
                    data: {
                        category_id: newCategoryId,
                        position: newPosition
                    },
                    success: function(response) {
                        showToast('Tarefa movida com sucesso!');
                    },
                    error: function(xhr) {
                        showToast('Erro ao mover tarefa', 'error');
                        // Revert the move
                        $(this).sortable('cancel');
                    }
                });
            }
        }
    }).disableSelection();
}
</script>
@endsection
