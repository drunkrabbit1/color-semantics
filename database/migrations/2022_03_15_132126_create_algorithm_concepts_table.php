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
        Schema::create('algorithm_concepts', function (Blueprint $table) {

            $table->foreignUuid('concept_id')->nullable()->references('id')->on('concepts')
                ->cascadeOnDelete();
            $table->foreignUuid('algorithm_id')->nullable()->references('id')->on('algorithms')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('algorithm_concepts');
    }
};
