<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableRt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rt', function (Blueprint $table) {
            $table->id();
            $table->string('rt', 20);
            $table->string('rw', 20);
            $table->string('kelurahan', 20);
            $table->string('kecamatan', 20);
            $table->string('kab_kota', 20);
            $table->string('provinsi', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
