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
            //
            $table->tinyInteger('availability')->default(0)->nullable();
            $table->dropColumn('available');
            $table->dropColumn('sold');
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
            //
            $table->dropColumn('availability');
            $table->boolean('sold')->default(false)->nullable();
            $table->boolean('available')->default(true);
        });
    }
};
