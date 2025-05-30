<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAiRecommendationsTable extends Migration
{
    public function up()
    {
        Schema::create('ai_recommendations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_profile_id');
            $table->text('insights');                           // Store raw AI response
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_profile_id')
                  ->references('id')
                  ->on('user_profiles')
                  ->onDelete('cascade');                        // Remove recs if profile is deleted
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_recommendations');
    }
}
