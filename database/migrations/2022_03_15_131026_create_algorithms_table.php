<?php

use Drabbit\ColorSemantics\Enums\AlgorithmType;
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
        Schema::create('algorithms', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->text('description')->nullable();

            $table->integer('point')->nullable();
            $table->enum('type', collect(AlgorithmType::cases())->pluck('value')->toArray())->nullable();

            $table->uuid('algorithm_id')->nullable();

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
        Schema::dropIfExists('algorithms');
    }
};
