<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableWarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->integer('id_rt')->nullable();
            $table->string('nama', 50);
            $table->string('nik', 20)->unique();
            $table->text('alamat');
            $table->string('no_hp', 15);
            $table->string('foto', 50);
            $table->string('jml_anggota_keluarga', 3);
            $table->string('email', 50)->unique();
            $table->string('no_kk', 20);
            $table->string('password', 80);
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
        Schema::dropIfExists('warga');
    }
}
