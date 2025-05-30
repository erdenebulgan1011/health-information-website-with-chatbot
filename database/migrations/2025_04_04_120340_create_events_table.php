<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('location')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });


    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};


// public function up(): void
//     {
//         Schema::create('vr_content_details', function (Blueprint $table) {  // Ensure correct table name
//             $table->id();
//             $table->foreignId('vr_content_id')->constrained('vr_contents')->onDelete('cascade');
//             $table->string('title');
//             $table->text('content');
//             $table->integer('order')->default(0);
//             $table->timestamps();
//         });

//     }
//     public function down(): void
//     {
//         Schema::dropIfExists('v_r_content_details');
//     }

//     Schema::create('test_categories', function (Blueprint $table) {
//             $table->id();
//             $table->string('name');
//             $table->string('slug')->unique();
//             $table->text('description');
//             $table->string('icon')->nullable();
//             $table->boolean('is_active')->default(true);
//             $table->timestamps();
//         });

//         // Test Sessions & Responses
//         Schema::create('test_sessions', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->constrained();
//             $table->foreignId('test_category_id')->constrained();
//             $table->timestamp('completed_at')->nullable();
//             $table->json('results')->nullable();
//             $table->timestamps();
//         });
//         // Health Metrics
//         Schema::create('health_metrics', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')->constrained();
//             $table->string('metric_type'); // weight, blood_pressure, heart_rate, etc.
//             $table->decimal('value', 8, 2);
//             $table->string('unit'); // kg, mmHg, bpm, etc.
//             $table->timestamp('recorded_at');
//             $table->string('source'); // manual, fitbit, apple_health, etc.
//             $table->timestamps();
//         });

//         // Recommendations & Resources
//         Schema::create('recommendations', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('test_category_id')->constrained();
//             $table->string('condition'); // high_stress, low_bmi, etc.
//             $table->text('recommendation_text');
//             $table->string('severity_level'); // info, warning, danger
//             $table->text('action_steps')->nullable();
//             $table->timestamps();
//         });

//         Schema::create('resources', function (Blueprint $table) {
//             $table->id();
//             $table->string('title');
//             $table->text('description');
//             $table->string('type'); // article, video, exercise, diet_plan
//             $table->string('url')->nullable();
//             $table->json('tags');
//             $table->boolean('is_premium')->default(false);
//             $table->timestamps();
//         });
//                 Schema::create('questions', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('test_category_id')->constrained()->onDelete('cascade');
//             $table->text('question_text');
//             $table->string('question_type'); // multiple_choice, scale, boolean, text
//             $table->json('options')->nullable(); // For multiple choice questions
//             $table->integer('weight')->default(1); // Question importance
//             $table->boolean('is_required')->default(true);
//             $table->timestamps();
//         });
//         Schema::create('responses', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('test_session_id')->constrained()->onDelete('cascade');
//             $table->foreignId('question_id')->constrained();
//             $table->text('response_value'); // Store as text for flexibility
//             $table->integer('score')->nullable(); // Calculated score based on answer
//             $table->timestamps();
//         });
//         // Хэрэглэгчийн профайл
// Schema::create('profiles', function (Blueprint $table) {
//     $table->id();
//     $table->foreignId('user_id')->constrained()->onDelete('cascade');
//     $table->string('avatar')->nullable();
//     $table->text('bio')->nullable();
//     $table->string('location')->nullable();
//     $table->timestamps();
// });
