<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar se o usuário já existe
        $existingUser = User::where('email', 'admin@admin.com')->first();

        if ($existingUser) {
            $this->command->info('Usuário admin já existe!');
            $this->command->info('Email: admin@admin.com');
            $this->command->info('Senha: 123456');
            return;
        }

        // Criar usuário admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
        ]);

        $this->command->info('✓ Usuário admin criado com sucesso!');
        $this->command->info('');
        $this->command->info('Credenciais de acesso:');
        $this->command->info('Email: admin@admin.com');
        $this->command->info('Senha: 123456');
    }
}
