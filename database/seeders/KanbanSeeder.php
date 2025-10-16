<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KanbanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo user
        $user = User::create([
            'name' => 'Usuário Demo',
            'email' => 'demo@kanbanvox.com',
            'password' => Hash::make('password'),
        ]);

        // Create a sample board
        $board = Board::create([
            'user_id' => $user->id,
            'title' => 'Projeto de Desenvolvimento Web',
            'description' => 'Quadro para gerenciar tarefas do projeto web',
        ]);

        // Create categories
        $todo = Category::create([
            'board_id' => $board->id,
            'title' => 'To Do',
            'position' => 0,
        ]);

        $inProgress = Category::create([
            'board_id' => $board->id,
            'title' => 'Em Progresso',
            'position' => 1,
        ]);

        $testing = Category::create([
            'board_id' => $board->id,
            'title' => 'Em Teste',
            'position' => 2,
        ]);

        $done = Category::create([
            'board_id' => $board->id,
            'title' => 'Concluído',
            'position' => 3,
        ]);

        // Create tasks for To Do
        Task::create([
            'category_id' => $todo->id,
            'title' => 'Implementar sistema de login',
            'description' => 'Criar páginas de login e registro com validação',
            'position' => 0,
        ]);

        Task::create([
            'category_id' => $todo->id,
            'title' => 'Desenvolver API REST',
            'description' => 'Criar endpoints para CRUD de recursos',
            'position' => 1,
        ]);

        // Create tasks for In Progress
        Task::create([
            'category_id' => $inProgress->id,
            'title' => 'Design da interface',
            'description' => 'Criar mockups e protótipos da interface do usuário',
            'position' => 0,
        ]);

        Task::create([
            'category_id' => $inProgress->id,
            'title' => 'Configurar banco de dados',
            'description' => 'Criar migrations e seeders',
            'position' => 1,
        ]);

        // Create tasks for Testing
        Task::create([
            'category_id' => $testing->id,
            'title' => 'Testes unitários',
            'description' => 'Escrever testes para models e controllers',
            'position' => 0,
        ]);

        // Create tasks for Done
        Task::create([
            'category_id' => $done->id,
            'title' => 'Setup inicial do projeto',
            'description' => 'Instalação do Laravel e configuração básica',
            'position' => 0,
        ]);

        Task::create([
            'category_id' => $done->id,
            'title' => 'Estrutura de pastas',
            'description' => 'Organização da estrutura do projeto',
            'position' => 1,
        ]);

        $this->command->info('Seeder executado com sucesso!');
        $this->command->info('Email: demo@kanbanvox.com');
        $this->command->info('Senha: password');
    }
}
