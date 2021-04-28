<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVajilladescartableToDetallerelevamientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detallerelevamiento', function (Blueprint $table) {
            //agrego PiezaPseudonimo
            if (!Schema::hasColumn('detallerelevamiento', 'DetalleRelevamientoVajillaDescartable')){
                $table->integer('DetalleRelevamientoVajillaDescartable');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detallerelevamiento', function (Blueprint $table) {
            //
        });
    }
}
