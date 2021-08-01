<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableAdminRt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_rt', function (Blueprint $table) {
            $table->id();
            $table->integer('id_rt');
            $table->string('nik', 20);
            $table->string('nama', 50);
            $table->string('email', 50);
            $table->string('no_hp', 20);
            $table->text('alamat', 20);
            $table->string('password', 80);
            $table->string('jabatan', 20);
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
