<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'Osnovni',
                'price' => 49.99,
                'duration_days' => 30,
                'description' => 'Pristup teretani i osnovnoj opremi.',
            ],
            [
                'name' => 'Premium',
                'price' => 79.99,
                'duration_days' => 30,
                'description' => 'Potpuni pristup uključujući grupne treninge i popust na personalnog trenera.',
            ],
            [
                'name' => 'Studentski',
                'price' => 39.99,
                'duration_days' => 30,
                'description' => 'Povoljna cijena za studente sa važećom studentskom legitimacijom.',
            ],
            [
                'name' => 'Sportista Pro',
                'price' => 99.99,
                'duration_days' => 30,
                'description' => 'Premium članstvo sa svim pogodnostima i prioritetnim rezervacijama.',
            ],
        ];

        foreach ($plans as $plan) {
            DB::table('plans')->updateOrInsert(
                ['name' => $plan['name']],
                $plan
            );
        }
    }
}
