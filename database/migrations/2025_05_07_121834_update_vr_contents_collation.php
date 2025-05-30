<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vr_contents', function (Blueprint $table) {
            $table->string('title')->collation('utf8mb4_unicode_ci')->change();
            $table->text('description')->collation('utf8mb4_unicode_ci')->change();
        });
    }

    public function down(): void
    {
        Schema::table('vr_contents', function (Blueprint $table) {
            $table->string('title')->collation('utf8mb4_general_ci')->change();
            $table->text('description')->collation('utf8mb4_general_ci')->change();
        });
    }
};
