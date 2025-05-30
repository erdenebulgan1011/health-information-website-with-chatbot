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
        Schema::table('events', function (Blueprint $table) {
            // Add new columns after existing ones
            $table->unsignedBigInteger('category_id')->nullable()->after('url');
            $table->unsignedBigInteger('organizer_id')->nullable()->after('category_id');
            $table->string('address')->nullable()->after('location');
            $table->string('city')->nullable()->after('address');
            $table->integer('max_attendees')->nullable()->after('city');
            $table->boolean('is_featured')->default(false)->after('max_attendees');
            $table->dateTime('registration_deadline')->nullable()->after('is_featured');
            $table->string('image_url')->nullable()->after('registration_deadline');
            $table->string('status')->default('active')->after('image_url');
            $table->string('color')->nullable()->after('status');
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null');

            $table->foreign('organizer_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['category_id']);
            $table->dropForeign(['organizer_id']);

            // Then drop columns
            $table->dropColumn([
                'category_id',
                'organizer_id',
                'address',
                'city',
                'max_attendees',
                'is_featured',
                'registration_deadline',
                'image_url',
                'status',
                'color',
            ]);

            // Drop soft deletes column
            $table->dropSoftDeletes();
        });
    }
};
