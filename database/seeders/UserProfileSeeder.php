<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\UserProfile;
use Carbon\Carbon;


class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all users
        $users = User::all();
$defaultCount = 13;
        foreach ($users as $user) {
            // Random birth dates between 18-80 years old
            $birthDate = Carbon::now()->subYears(rand(18, 80))->subDays(rand(0, 365));
                $index = rand(1, $defaultCount);  // or mt_rand(1, $defaultCount) :contentReference[oaicite:2]{index=2}

    $profilePic = "images/default_{$index}.jpg";  // local files only :contentReference[oaicite:3]{index=3}

            // Create profiles with random health data
            UserProfile::create([
                'user_id' => $user->id,
                'birth_date' => $birthDate,
                'gender' => rand(0, 1) ? 'эр' : 'эм',
                'height' => rand(150, 195),
                'weight' => rand(450, 1200) / 10, // Generate weight between 45.0 and 120.0 kg
                'is_smoker' => rand(0, 3) === 0, // 25% chance of being a smoker
                'has_chronic_conditions' => rand(0, 4) === 0, // 20% chance of having chronic conditions
                'medical_history' => $this->generateMedicalHistory(),
        'profile_pic'               => $profilePic,            // ← random default pic :contentReference[oaicite:4]{index=4}
            ]);
        }

}
/**
     * Generate random medical history text.
     *
     * @return string|null
     */
    private function generateMedicalHistory()
    {
        $histories = [
            null,
            'Харшилтай: Үнс тоос.',
            'Өвдөг өвдөж байсан.',
            'Цусны даралт өндөр. Эмчийн хяналтанд.',
            'Зүрхний титэм судасны өвчтэй. 2020 онд мэс засал хийлгэсэн.',
            'Чихрийн шижин 2-р хэлбэр. Эмчийн хяналтанд.',
            'Хоол боловсруулах эрхтний өвчлөлтэй. Ходоодны шархлаа.',
            'Харшилтай: Сээр нуруутны хоол, антибиотик.',
            'Астма өвчтэй. Дархлалын өвчлөл.',
            'Бамбай булчирхайн үйл ажиллагаа сул.',
        ];

        return $histories[array_rand($histories)];
    }

}
