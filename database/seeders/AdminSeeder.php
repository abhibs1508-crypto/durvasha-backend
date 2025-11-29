<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@techstrota.com'], // Identifier
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                // 'is_admin' => true ?? 1, // optional if you have admin column
            ]
        );
    }
}
