<?php

use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\MutasiPindah;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mutasi_pindah_penduduks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('keluarga_sebelumnya')->references('id')->on('keluargas')->onDelete('cascade');
            $table->foreignIdFor(Keluarga::class)->references('id')->on('keluargas')->onDelete('cascade');
            $table->foreignIdFor(MutasiPindah::class)->references('id')->on('mutasi_pindahs')->onDelete('cascade');
            $table->foreignIdFor(Penduduk::class)->references('id')->on('penduduks')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_pindah_penduduks');
    }
};
