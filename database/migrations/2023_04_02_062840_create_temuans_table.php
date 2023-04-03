<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temuans', function (Blueprint $table) {
            $table->id();
            $table->string('pengawas_bidang');
            $table->integer('status');
            $table->string('penanggung_jawab_tindak_lanjut');
            $table->integer('penanggung_jawab_tindak_lanjut_tipe');
            $table->string('tindak_lanjut');
            $table->string('tanggal_tindak_lanjut');
            $table->foreignId('hakim_pengawas_bidang');
            $table->integer('triwulan');
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
        Schema::dropIfExists('temuans');
    }
}
