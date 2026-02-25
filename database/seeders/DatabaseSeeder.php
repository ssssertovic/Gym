<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\DemoMembersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Admin user
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('Admin123!'),
                'role' => 'admin',
            ]
        );

        $this->call([
            PlanTableSeeder::class,
            TrainerTableSeeder::class,
            MemberTableSeeder::class,
            WorkoutTableSeeder::class,
            DemoMembersSeeder::class,
        ]);
    }
}
