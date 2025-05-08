<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::factory()->create([
            'name' => 'shaghayegh',
            'email' => 'shaghayeghk2001@gmail.com',
            'phone' => '09336892362',
            'status' => 1,
            'role' => 'super_admin',
            'password' => 123456,
        ]);
    }
}
