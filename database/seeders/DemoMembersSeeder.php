<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 demo gym members as users
        $bosnianNames = [
            'Amir Hadžić',
            'Emina Kovačević',
            'Nermin Selimović',
            'Lejla Džafić',
            'Haris Mehmedović',
            'Aida Milić',
            'Adnan Bektić',
            'Maja Krstić',
            'Faruk Musić',
            'Sara Jurić',
        ];

        $demoUserIds = [];

        foreach ($bosnianNames as $index => $name) {
            $email = 'demo.user' . ($index + 1) . '@gym.local';

            $height = rand(155, 195); // cm
            $weight = rand(55, 100);  // kg

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('user12345'),
                'height_cm' => $height,
                'weight_kg' => $weight,
                'role' => 'user',
            ]);

            $demoUserIds[] = $user->id;
        }

        // Prepare data for bookings seeding
        $memberUserIds = User::where('role', 'user')->pluck('id')->all();
        $planIds = DB::table('plans')->pluck('id')->all();
        $trainerIds = DB::table('trainers')->pluck('id')->all();

        if (empty($memberUserIds) || empty($planIds) || empty($trainerIds)) {
            return;
        }

        $notesOptions = [
            'Trening snage',
            'Kardio dan',
            'Cijelo tijelo',
            'Lagani prvi trening',
        ];

        // Create 10 demo bookings with future dates
        for ($i = 0; $i < 10; $i++) {
            $userId = $memberUserIds[array_rand($memberUserIds)];
            $planId = $planIds[array_rand($planIds)];
            $trainerId = $trainerIds[array_rand($trainerIds)];

            $scheduledAt = Carbon::now()->addDays(rand(1, 30))->setTime(rand(7, 20), [0, 30][array_rand([0, 30])]);

            Booking::create([
                'user_id' => $userId,
                'plan_id' => $planId,
                'trainer_id' => $trainerId,
                'scheduled_at' => $scheduledAt,
                'notes' => $notesOptions[array_rand($notesOptions)],
            ]);
        }
    }
}

