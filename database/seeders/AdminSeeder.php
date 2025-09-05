<?php

namespace Database\Seeders;

use App\Models\users\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'user_id' => 'ADMTSU01',
            'name' => 'Admin Dummy 1',
            'email' => 'admin123@email.com',
            'password' => bcrypt('admin123'),
            'avatar' => 'https://ui-avatars.com/api/?name=Admin+Dummy+1&background=random',
        ]);
    }
}
