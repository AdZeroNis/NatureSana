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
            'email' => 'shaghayegh@gmail.com',
            'phone' => '09336892362',
            'address' => '123 Main St',
            'status' => 1,
            'role' => 'super_admin',
            'password' => 123456,
        ]);

        Store::create([
            'name' => 'فروشگاه اصلی',
            'address' => 'تهران، خیابان ولیعصر',
            'phone_number' => '02112345678',
            'admin_id' => $admin->id,
            'image' => 'default-store.jpg',
        ]);
    }
}
