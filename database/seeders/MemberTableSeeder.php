<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberTableSeeder extends Seeder
{
    public function run()
    {
        $members = [];
        $planIds = DB::table('plans')->pluck('id')->toArray();
        if (empty($planIds)) {
            return;
        }

        $names = [
            ['Haris', 'Kovačević'],
            ['Amra', 'Hodžić'],
            ['Amina', 'Džafić'],
            ['Lejla', 'Mujić'],
            ['Emir', 'Halilović'],
            ['Adnan', 'Mehmedović'],
            ['Jasmina', 'Osmanović'],
            ['Nedim', 'Kurtović'],
            ['Selma', 'Avdić'],
            ['Ajla', 'Begić']
        ];
        
        for ($i = 0; $i < 10; $i++) {
            $members[] = [
                'name' => $names[$i][0] . ' ' . $names[$i][1],
                'year' => now()->subYears(rand(20, 50))->format('Y-m-d'),
                'engine' => rand(60, 95) + (rand(0, 99) / 100),
                'code' => 1000 + $i,
                'air_condition' => rand(0, 1),
                'plan' => $planIds[array_rand($planIds)],
                'height_cm' => rand(165, 190),
                'body_fat_percentage' => rand(15, 28) + (rand(0, 99) / 100),
            ];
        }

        foreach ($members as $m) {
            DB::table('members')->insert($m);
        }
    }
}
