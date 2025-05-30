<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Professional;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\File;

class ProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get the doctor users from your UserSeeder
        $doctor1 = User::where('email', 'doctor1@healthinfo.com')->first();
        $doctor2 = User::where('email', 'doctor2@healthinfo.com')->first();

        // Create certification directory if it doesn't exist
        $certPath = public_path('certifications');
        if (!File::isDirectory($certPath)) {
            File::makeDirectory($certPath, 0755, true);
        }

        // Sample certification file
        $sampleCertFile = 'certifications/1747658243_Lame.pdf';

        // Create professionals for doctor users
        Professional::create([
            'user_id' => $doctor1->id,
            'specialization' => 'Кардиолог',
            'qualification' => 'Ph.D, Анагаах Ухааны Их Сургууль',
            'certification' => $sampleCertFile,
            'bio' => 'Батбаяр нь 15 жилийн туршлагатай кардиологи мэргэжилтэн бөгөөд зүрхний өвчний оношилгоо, эмчилгээнд мэргэшсэн.',
            'is_verified' => true,
        ]);

        Professional::create([
            'user_id' => $doctor2->id,
            'specialization' => 'Эмэгтэйчүүдийн эмч',
            'qualification' => 'MD, Эх Барих Эмэгтэйчүүдийн Эмнэлэг',
            'certification' => $sampleCertFile,
            'bio' => 'Оюунчимэг нь эмэгтэйчүүдийн эрүүл мэндийн асуудлаар 10 гаруй жилийн туршлагатай мэргэжилтэн.',
            'is_verified' => true,
        ]);

        // Create additional international doctors
        $internationalDoctors = [
            [
                'name' => 'Dr. Suzanne Morar DDS',
                'email' => 'smorar@healthinfo.com',
                'specialization' => 'Шүдний эмч',
                'qualification' => 'DDS, Harvard Dental School',
                'bio' => 'Dr. Morar specializes in cosmetic dentistry with over 15 years of experience in dental implants and smile design.'
            ],
            [
                'name' => 'Dr. Moises Smith',
                'email' => 'msmith@healthinfo.com',
                'specialization' => 'Мэс засалч',
                'qualification' => 'MD, Johns Hopkins University',
                'bio' => 'Dr. Smith is a board-certified surgeon specializing in minimally invasive procedures with 12 years of clinical experience.'
            ],
            [
                'name' => 'Dr. Emily Chen',
                'email' => 'echen@healthinfo.com',
                'specialization' => 'Хүүхдийн эмч',
                'qualification' => 'MD, Stanford Medical School',
                'bio' => 'Dr. Chen is a pediatrician with expertise in childhood development and preventive care.'
            ],
            [
                'name' => 'Dr. Hiroshi Tanaka',
                'email' => 'htanaka@healthinfo.com',
                'specialization' => 'Мэдрэлийн эмч',
                'qualification' => 'MD, PhD, Tokyo Medical University',
                'bio' => 'Dr. Tanaka is a neurologist specializing in stroke prevention and neurorehabilitation.'
            ],
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sjohnson@healthinfo.com',
                'specialization' => 'Дотрын эмч',
                'qualification' => 'MD, Yale School of Medicine',
                'bio' => 'Dr. Johnson is an internal medicine specialist with expertise in chronic disease management.'
            ],
            [
                'name' => 'Dr. Carlos Rodriguez',
                'email' => 'crodriguez@healthinfo.com',
                'specialization' => 'Зүрхний эмч',
                'qualification' => 'MD, Barcelona Medical Institute',
                'bio' => 'Dr. Rodriguez specializes in interventional cardiology with experience in complex cardiac procedures.'
            ],
        ];

        foreach ($internationalDoctors as $doctorData) {
            // Create user first
            $user = User::create([
                'name' => $doctorData['name'],
                'email' => $doctorData['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('doctor123'),
            ]);

            // Create professional record
            Professional::create([
                'user_id' => $user->id,
                'specialization' => $doctorData['specialization'],
                'qualification' => $doctorData['qualification'],
                'certification' => $sampleCertFile,
                'bio' => $doctorData['bio'],
                'is_verified' => true,
            ]);
        }

        // Turn some regular users into professionals with varying verification status
        $regularUsers = User::where('email', 'not like', '%doctor%')
                           ->where('email', 'not like', '%healthinfo.com')
                           ->where('email', '!=', 'erdenebulgan1011@gmail.com')
                           ->take(3)
                           ->get();

        $specializations = [
            'Шүдний эмч', 'Нүдний эмч', 'Хүүхдийн эмч', 'Мэдрэлийн эмч', 'Сэтгэл зүйч'
        ];

        $qualifications = [
            'MD, Анагаах Ухааны Их Сургууль',
            'Ph.D, Эрүүл Мэндийн Шинжлэх Ухааны Их Сургууль',
            'MS, Клиникийн Анагаах Ухаан'
        ];

        foreach ($regularUsers as $index => $user) {
            Professional::create([
                'user_id' => $user->id,
                'specialization' => $specializations[$index % count($specializations)],
                'qualification' => $qualifications[$index % count($qualifications)],
                'certification' => $sampleCertFile,
                'bio' => 'Эрүүл мэндийн салбарт ' . rand(3, 20) . ' жилийн туршлагатай мэргэжилтэн.',
                'is_verified' => rand(0, 1) > 0,
            ]);
        }
    }


}
