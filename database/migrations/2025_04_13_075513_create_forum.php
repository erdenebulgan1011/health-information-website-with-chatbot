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
        // Сэдвүүд (хэлэлцүүлгүүд)
Schema::create('topics', function (Blueprint $table) {
    $table->id();
    $table->string('title')->collation('utf8mb4_unicode_ci');
    $table->text('content')->collation('utf8mb4_unicode_ci');

    $table->string('slug')->unique();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->integer('views')->default(0);
    $table->boolean('is_pinned')->default(false);
    $table->boolean('is_locked')->default(false);
    $table->timestamps();
});

// Хариултууд (коммент)
Schema::create('replies', function (Blueprint $table) {
    $table->id();
    $table->text('content');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('topic_id')->constrained()->onDelete('cascade');
    $table->foreignId('parent_id')->nullable()->constrained('replies')->onDelete('cascade');
    $table->boolean('is_best_answer')->default(false);
    $table->timestamps();
});

// Дуртай зүйлс
Schema::create('likes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->morphs('likeable'); // Topic эсвэл Reply-д дуртай байх боломжтой
    $table->timestamps();
});

// Мэргэжилтнүүд
Schema::create('professionals', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('specialization');
    $table->string('qualification');
    $table->string('certification')->nullable(); // Must match exactly
    // Stores file path to certification document
    $table->text('bio')->nullable();
    $table->boolean('is_verified')->default(false);
    $table->timestamps();
});
// Мэдэгдлүүд
Schema::create('notifications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('type');
    $table->morphs('notifiable');
    $table->text('data');
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
});

// Тэмдэглэгээнүүд
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->timestamps();
});

// Сэдэв ба тэмдэглэгээний холбоос
Schema::create('tag_topic', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tag_id')->constrained()->onDelete('cascade');
    $table->foreignId('topic_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});

// Эрүүл мэндийн материалууд
Schema::create('health_resources', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('content');
    $table->string('file_path')->nullable();
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('health_resources');
    Schema::dropIfExists('tag_topic');
    Schema::dropIfExists('tags');
    Schema::dropIfExists('notifications');
    Schema::dropIfExists('professionals');
    Schema::dropIfExists('likes');
    Schema::dropIfExists('replies');
    Schema::dropIfExists('topics');
}

};
