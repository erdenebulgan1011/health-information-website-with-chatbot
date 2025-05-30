<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Professional;
use App\Models\DoctorInfo;
class DoctorInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all professionals
        $professionals = Professional::all();

        $workplaces = [
            'Улсын Клиникийн Нэгдүгээр Эмнэлэг',
            'Нийслэлийн Эмнэлэг',
            'Интермед Эмнэлэг',
            'Гранд Мед Эмнэлэг',
            'Улсын Гуравдугаар Эмнэлэг',
            'Mercy Hospital',
            'St. Luke\'s Medical Center',
            'Tokyo Medical Center',
            'Barcelona Heart Institute',
            'Stanford Children\'s Hospital'
        ];

        $addresses = [
            'Баянзүрх дүүрэг, 4-р хороо',
            'Сүхбаатар дүүрэг, 1-р хороо',
            'Хан-Уул дүүрэг, 2-р хороо',
            'Чингэлтэй дүүрэг, 5-р хороо',
            'Сонгинохайрхан дүүрэг, 6-р хороо',
            '123 Medical Plaza, Boston, MA',
            '456 Health Avenue, San Francisco, CA',
            '789 Clinic Street, Tokyo, Japan',
            '101 Hospital Road, Barcelona, Spain',
            '202 Doctor Drive, New York, NY'
        ];

        $education = [
            'АШУҮИС-ийн Анагаах Ухааны Сургууль',
            'ЭМШУИС-ийн Эмнэлзүйн Анагаах Ухаан',
            'Оросын Анагаах Ухааны Их Сургууль',
            'Солонгосын Сөүлийн Их Сургууль',
            'УНТЭ-ийн Эмнэлзүйн Резидент',
            'Harvard Medical School',
            'Johns Hopkins University School of Medicine',
            'Stanford University School of Medicine',
            'Tokyo Medical University',
            'Yale University School of Medicine',
            'University of Barcelona Medical School'
        ];

        $languages = [
            'Монгол, Англи',
            'Монгол, Орос',
            'Монгол, Англи, Орос',
            'Монгол, Хятад',
            'Монгол, Солонгос, Англи',
            'English, Spanish',
            'English, Mandarin',
            'Japanese, English',
            'Spanish, English, Catalan',
            'English, French'
        ];

        foreach ($professionals as $professional) {
            // Get user information for the full name
            $user = $professional->user;

            // Special handling for international doctors
            $isInternationalDoctor = strpos($user->email, '@healthinfo.com') !== false &&
                                    $user->email != 'doctor1@healthinfo.com' &&
                                    $user->email != 'doctor2@healthinfo.com';

            // Set workplace and address based on doctor type
            $workplace = $isInternationalDoctor ?
                $workplaces[array_rand(array_slice($workplaces, 5, 5))] :
                $workplaces[array_rand(array_slice($workplaces, 0, 5))];

            $address = $isInternationalDoctor ?
                $addresses[array_rand(array_slice($addresses, 5, 5))] :
                $addresses[array_rand(array_slice($addresses, 0, 5))];

            $education_value = $isInternationalDoctor ?
                $education[array_rand(array_slice($education, 5, 6))] :
                $education[array_rand(array_slice($education, 0, 5))];

            $languages_value = $isInternationalDoctor ?
                $languages[array_rand(array_slice($languages, 5, 5))] :
                $languages[array_rand(array_slice($languages, 0, 5))];

            // Years of experience based on email domain
            $yearsExperience = $isInternationalDoctor ? rand(8, 25) : rand(3, 20);

            // Create doctor info record
            DoctorInfo::create([
                'professional_id' => $professional->id,
                'full_name' => $user->name, // Using the name from the user table
                'phone_number' => $isInternationalDoctor ?
                    '+1' . rand(2000000000, 9999999999) :
                    '976' . rand(10000000, 99999999),
                'workplace' => $workplace,
                'address' => $address,
                'education' => $education_value,
                'years_experience' => $yearsExperience,
                'languages' => $languages_value,
            ]);
        }
    }


}
