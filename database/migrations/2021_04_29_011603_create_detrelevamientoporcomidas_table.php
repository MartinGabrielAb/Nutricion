<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetrelevamientoporcomidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('detrelevamientoporcomida')) {
            Schema::create('detrelevamientoporcomida', function (Blueprint $table) {
                $table->id("DetRelevamientoPorComidaId");
                $table->integer("DetalleRelevamientoId");
                $table->foreign('DetalleRelevamientoId')->references('DetalleRelevamientoId')->on('detallerelevamiento')->onDelete('cascade');
                $table->integer("ComidaId");
                $table->foreign('ComidaId')->references('ComidaId')->on('comida')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detrelevamientoporcomidas');
    }
}
