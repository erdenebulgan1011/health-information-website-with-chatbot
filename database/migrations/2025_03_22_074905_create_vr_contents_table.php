<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // public function up()
    // {
    //     Schema::create('vr_contents', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('title')->collation('utf8mb4_unicode_ci');
    //         $table->text('description')->collation('utf8mb4_unicode_ci');
    //                 $table->string('sketchfab_uid')->unique();
    //         $table->foreignId('category_id')
    //               ->constrained('categories')
    //               ->onDelete('cascade');
    //         $table->string('status')->default('draft');
    //         $table->boolean('featured')->default(false);
    //         $table->json('metadata')->nullable();
    //         $table->timestamps();
    //     });
    // }


    // public function down()
    // {
    //     Schema::dropIfExists('vr_contents');
    // }
};

