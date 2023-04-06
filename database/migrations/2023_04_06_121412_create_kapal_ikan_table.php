<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kapal_ikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('kode_kapal');
            $table->string('nama_kapal');
            $table->string('nama_pemilik');
            $table->string('alamat_pemilik');
            $table->integer('ukuran_kapal');
            $table->string('kapten');
            $table->integer('jumlah_anggota');
            $table->string('foto_kapal');
            $table->string('nomor_izin');
            $table->string('dokumen_perizinan');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('catatan')->nullable();
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
        Schema::dropIfExists('kapal_ikan');
    }
};
