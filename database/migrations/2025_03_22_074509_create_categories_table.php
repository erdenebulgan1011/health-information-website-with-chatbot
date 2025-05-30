<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->string('icon')->nullable(); // Column for image storage

        // Set the table's default character set and collation
        $table->charset = 'utf8mb4';
        $table->collation = 'utf8mb4_unicode_ci';

        $table->timestamps();
    });



    // Schema::create('categories', function (Blueprint $table) {
    //     $table->id();
    //     $table->string('name');
    //     $table->string('slug');
    //     $table->text('description');
    //     $table->string('icon'); // ensure the icon column supports UTF-8
    //     $table->timestamps();
    // })->charset('utf8mb4')->collation('utf8mb4_unicode_ci');

}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('categories');
            Schema::dropIfExists('related_table'); // Drop related tables first
    Schema::enableForeignKeyConstraints();

    }
};
