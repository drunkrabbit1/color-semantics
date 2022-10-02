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
        Schema::create('test_concept_pivot', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('test_id')->references('id')->on('tests')
                ->cascadeOnDelete();
            $table->foreignUuid('concept_id')->references('id')->on('concepts')
                ->cascadeOnDelete();

            $table->index(['test_id', 'concept_id'], 'test_concept');

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
        Schema::dropIfExists('test_concept_pivot');
    }
};
