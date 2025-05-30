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
        //
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->integer('height')->nullable();
            $table->decimal('weight', 5, 2)
          ->nullable()
          ->comment('Weight in kilograms');
            $table->boolean('is_smoker')->default(false);
            $table->boolean('has_chronic_conditions')->default(false);
            $table->text('medical_history')->nullable();
            $table->text('profile_pic')->nullable(); // adjust 'after' if needed

            $table->timestamps();
        });
        // External Connections
        Schema::create('connected_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('provider'); // fitbit, apple_health, google_fit
            $table->string('access_token');
            $table->string('refresh_token')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('scopes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    // Drop foreign key constraints first to avoid issues
    Schema::table('user_profiles', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
    });
    // Schema::table('questions', function (Blueprint $table) {
    //     $table->dropForeign(['test_category_id']);
    // });
    // Schema::table('test_sessions', function (Blueprint $table) {
    //     $table->dropForeign(['user_id', 'test_category_id']);
    // });
    // Schema::table('responses', function (Blueprint $table) {
    //     $table->dropForeign(['test_session_id', 'question_id']);
    // });
    // Schema::table('health_metrics', function (Blueprint $table) {
    //     $table->dropForeign(['user_id']);
    // });
    // Schema::table('recommendations', function (Blueprint $table) {
    //     $table->dropForeign(['test_category_id']);
    // });
    Schema::table('connected_devices', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
    });
    Schema::dropIfExists('user_profiles');
    Schema::dropIfExists('connected_devices');
}

};
