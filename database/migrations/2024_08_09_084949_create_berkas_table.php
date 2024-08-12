<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->text('kode_berkas');
            $table->text('nama_pihak_pertama');
            $table->text('nama_pihak_kedua');
            $table->text('jenis_berkas');
            $table->text('file_ktp_pihak_pertama');
            $table->text('file_ktp_pihak_kedua');
            $table->text('file_kk_pihak_pertama');
            $table->text('file_kk_pihak_kedua');
            $table->text('file_dokumen_pendukung');
            $table->text('status_berkas');
            $table->date('tanggal_berkas');
            $table->date('tanggal_akta');
            $table->text('no_akta');
            $table->text('file_akta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('berkas');
    }
};
