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
        Schema::table('flats', function (Blueprint $table) {
            $table->boolean('has_third_floor')->default(false)->nullable()->after('second_image_id');
            $table->unsignedInteger('third_floor_location')->nullable()->after('has_third_floor');
            $table->foreignId('third_image_id')->nullable()->after('third_floor_location')->constrained('files')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flats', function (Blueprint $table) {
            $table->dropForeign(['third_image_id']);
            $table->dropColumn(['has_third_floor', 'third_floor_location', 'third_image_id']);
        });
    }
};
