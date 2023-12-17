<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Order::factory(10)->create();

        $adminEmail = 'admin@admin.com';

        $adminExists = DB::table('users')->where('email', $adminEmail)->exists();

        if (!$adminExists) {
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => $adminEmail,
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]);
        }
    }
}
