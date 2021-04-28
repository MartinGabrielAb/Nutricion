<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalapseudonimoToSalaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sala', function (Blueprint $table) {
            //agrego SalaPseudonimo
            if (!Schema::hasColumn('sala', 'SalaPseudonimo')){
                $table->string('SalaPseudonimo');
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
        Schema::table('sala', function (Blueprint $table) {
            //
        });
    }
}
