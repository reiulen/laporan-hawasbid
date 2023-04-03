<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemuanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temuan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('temuan_id');
            $table->string('nomor_1');
            $table->string('nomor_2');
            $table->string('nomor_3');
            $table->string('tanggal_pelaksanaan_dari');
            $table->string('tanggal_pelaksanaan_sampai');
            $table->text('kondisi');
            $table->text('kriteria');
            $table->text('sebab');
            $table->text('akibat');
            $table->text('rekomendasi');
            $table->string('foto_eviden');
            $table->text('deskripsi_foto_eviden');
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
        Schema::dropIfExists('temuan_details');
    }
}
