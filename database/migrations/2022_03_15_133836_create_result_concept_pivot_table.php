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
        Schema::create('result_concept_pivot', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('result_id')->references('id')->on('results')
                ->cascadeOnDelete();
            $table->foreignUuid('color_id')->references('id')->on('colors')
                ->cascadeOnDelete();
            $table->foreignUuid('concept_id')->references('id')->on('concepts')
                ->cascadeOnDelete();
            $table->time('selection_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('result_concept_pivot');
    }
};
