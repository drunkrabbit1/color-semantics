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
        Schema::create('result_color_pivot', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->integer('index');

            $table->time('selection_time')->nullable();
            $table->timestamps();
        });

        Schema::table('result_color_pivot', function (Blueprint $table) {
            $table->foreignUuid('result_id')->constrained()->references('id')->on('results')
                ->cascadeOnDelete();
            $table->foreignUuid('color_id')->constrained()->references('id')->on('colors')
                ->cascadeOnDelete();
        });

        Schema::table('result_color_pivot', function (Blueprint $table) {
            $table->unique(['result_id', 'color_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('result_color_pivot');
    }
};
