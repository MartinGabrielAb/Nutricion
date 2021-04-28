<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropDetalleRelevamientoFechoraFromDetallerelevamientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detallerelevamiento', function (Blueprint $table) {
            //elimino DetalleRelevamientoFechora
            if (Schema::hasColumn('detallerelevamiento', 'DetalleRelevamientoFechora')){
                $table->dropColumn('DetalleRelevamientoFechora');
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
