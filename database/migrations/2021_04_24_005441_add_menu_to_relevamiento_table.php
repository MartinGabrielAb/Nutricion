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
        });
        Schema::table('detallerelevamiento', function (Blueprint $table){
            //agrego DetalleRelevamientoTurno
            if (!Schema::hasColumn('detallerelevamiento', 'DetalleRelevamientoTurno')){
                $table->string('DetalleRelevamientoTurno');
            }
            //agrego MenuId
            if (!Schema::hasColumn('detallerelevamiento', 'MenuId')){
                $table->integer('MenuId');
                $table->foreign('MenuId')->references('MenuId')->on('menu')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('relevamiento', function (Blueprint $table) {
            //elimino menuId como clave foranea
            if (Schema::hasColumn('relevamiento', 'MenuId')){
                $table->dropForeign(['MenuId']);
                $table->dropColumn('MenuId');
            }
        });
    }
}
