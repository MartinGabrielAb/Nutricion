<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMenuToRelevamientoTable extends Migration
{
    public function up()
    {
        Schema::table('relevamiento', function (Blueprint $table) {
            //elimino RelevamientoAcompaniantes
            if (Schema::hasColumn('relevamiento', 'RelevamientoAcompaniantes')){
                $table->dropColumn('RelevamientoAcompaniantes');
            }
            //elimino RelevamientoTurno
            if (Schema::hasColumn('relevamiento', 'RelevamientoTurno')){
                $table->dropColumn('RelevamientoTurno');
            }
            //agrego menuId como clave foranea
            if (!Schema::hasColumn('relevamiento', 'MenuId')){
                $table->integer('MenuId');
                $table->foreign('MenuId')->references('MenuId')->on('menu')->onDelete('cascade');
            }
        });
        Schema::table('detallerelevamiento', function (Blueprint $table){
            //agrego DetalleRelevamientoTurno como clave foranea
            if (!Schema::hasColumn('detallerelevamiento', 'DetalleRelevamientoTurno')){
                $table->string('DetalleRelevamientoTurno');
            }
        });
    }

    public function down()
    {
        Schema::table('relevamiento', function (Blueprint $table) {
        });
    }
}
