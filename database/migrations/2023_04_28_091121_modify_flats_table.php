<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
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
            $table->enum('type', ['apartment', 'loft']);
            $table->string('number');
            $table->boolean('available')->default(true);
            $table->integer('floor')->nullable();
            $table->integer('floor_location')->nullable();
            $table->integer('room_count')->nullable();
            $table->decimal('total_area')->default(0);
            $table->decimal('living_area')->default(0);
            $table->decimal('outdoor_area')->default(0);
            $table->decimal('price', 16, 2)->nullable();
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
            $table->dropColumn('type');
            $table->dropColumn('number');
            $table->dropColumn('available');
            $table->dropColumn('floor');
            $table->dropColumn('floor_location');
            $table->dropColumn('room_count');
            $table->dropColumn('total_area');
            $table->dropColumn('living_area');
            $table->dropColumn('outdoor_area');
            $table->dropColumn('price');
        });
    }
};
