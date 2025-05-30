<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('diseases', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('disease_id')->unique()->nullable(); // Nullable & Unique
            $table->string('disease_name');
            $table->text('common_symptom');
            $table->text('treatment');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diseases');
    }
};
