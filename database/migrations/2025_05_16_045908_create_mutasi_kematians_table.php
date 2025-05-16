<?php

use App\Models\Keluarga;
use App\Models\Penduduk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mutasi_kematians', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Keluarga::class)->references('id')->on('keluargas')->onDelete('cascade');
            $table->foreignIdFor(Penduduk::class)->references('id')->on('penduduks')->onDelete('cascade');

            $table->date('meninggal_pada');
            $table->string('tempat_meninggal');
            $table->string('penyebab_kematian');

            $table->string('foto_ktp')->nullable();
            $table->string('foto_kk')->nullable();
            $table->string('surat_keterangan_dokter')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_kematians');
    }
};
