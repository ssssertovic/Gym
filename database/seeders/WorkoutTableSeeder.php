<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkoutTableSeeder extends Seeder
{
    public function run()
    {
        $memberIds = DB::table('members')->pluck('id')->toArray();
        $trainerIds = DB::table('trainers')->pluck('id')->toArray();

        if (empty($memberIds) || empty($trainerIds)) {
            return;
        }

        $code = 1;
        $notes = [
            'Odličan trening',
            'Fokus na noge',
            'Kardio dan',
            'Trening snage',
            'Trening za oporavak',
            'HIIT sesija',
            'Cijelo tijelo',
            'Fokus na gornji dio tijela',
            'Intenzivna sesija',
            'Trening za izdržljivost'
        ];

        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays(rand(0, 60))->setHour(rand(8, 19))->setMinute(rand(0, 59));
            DB::table('workouts')->insert([
                'code' => $code++,
                'date' => $date,
                'grade' => rand(1, 5),
                'description' => $notes[array_rand($notes)],
                'trainer' => $trainerIds[array_rand($trainerIds)],
                'member' => $memberIds[array_rand($memberIds)],
            ]);
        }
    }
}
