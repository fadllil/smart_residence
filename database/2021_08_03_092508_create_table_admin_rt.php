<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAdminRt extends Migration
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
            $table->integer('id_users');
            $table->string('nama', 50);
            $table->string('nik', 20);
            $table->string('no_hp', 20);
            $table->text('alamat', 20);
            $table->string('jabatan', 20);
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
        Schema::dropIfExists('admin_rt');
    }
}
