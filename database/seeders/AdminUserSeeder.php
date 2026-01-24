<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::updateOrCreate(
            ['email' => 'admin@order-app.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@order-app.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        $this->command->info('Default admin user created:');
        $this->command->info('Email: admin@order-app.com');
        $this->command->info('Password: admin123');
    }
}
