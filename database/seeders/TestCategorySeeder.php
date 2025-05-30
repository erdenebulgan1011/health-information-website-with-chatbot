<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TestCategory;
use App\Models\Question;



class TestCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        TestCategory::create([
            'name' => 'Mental Health',
            'slug' => 'mental-health',
            'description' => 'A general mental health test to evaluate your emotional state.',
            'icon' => 'fas fa-brain',
            'is_active' => true,
        ]);

        TestCategory::create([
            'name' => 'Stress Level',
            'slug' => 'stress-level',
            'description' => 'Test to measure your stress levels and manage them effectively.',
            'icon' => 'fas fa-heartbeat',
            'is_active' => true,
        ]);
        Question::create([
            'test_category_id' => 1,  // assuming the first category is 'Mental Health'
            'question_text' => 'How often do you feel anxious?',
            'question_type' => 'scale',
            'options' => json_encode(['Rarely', 'Sometimes', 'Often', 'Always']),
            'weight' => 1,
            'is_required' => true,
        ]);

    }
}
