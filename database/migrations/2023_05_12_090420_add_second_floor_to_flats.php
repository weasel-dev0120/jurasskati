<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flats', function (Blueprint $table) {
            $table->boolean('has_second_floor')->default(false)->nullable();
            $table->integer('second_floor_location')->nullable();
            $table->foreignId('second_image_id')->nullable()->constrained('files')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flats', function (Blueprint $table) {
            $table->dropColumn('has_second_floor');
            $table->dropColumn('second_floor_location');
            $table->dropColumn('second_image_id');
        });
    }
};
