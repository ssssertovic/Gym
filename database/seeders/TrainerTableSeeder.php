<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainerTableSeeder extends Seeder
{
    public function run()
    {
        $trainers = [
            ['name' => 'Faris', 'lastname' => 'Kovačević', 'level' => 4, 'description' => 'Specijalista za trening snage'],
            ['name' => 'Džemila', 'lastname' => 'Hodžić', 'level' => 5, 'description' => 'Personalni trener, sertifikovana za jogu'],
            ['name' => 'Aldin', 'lastname' => 'Mehmedović', 'level' => 3, 'description' => 'Kardio i kondicioni trening'],
            ['name' => 'Emina', 'lastname' => 'Džafić', 'level' => 4, 'description' => 'CrossFit trener'],
            ['name' => 'Kenan', 'lastname' => 'Halilović', 'level' => 3, 'description' => 'Opšta kondicija'],
            ['name' => 'Aida', 'lastname' => 'Osmanović', 'level' => 5, 'description' => 'Sportska ishrana, upravljanje težinom'],
        ];

        foreach ($trainers as $t) {
            DB::table('trainers')->insert($t);
        }
    }
}
