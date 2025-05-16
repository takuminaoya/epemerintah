<?php

use App\Models\Dusun;
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
        Schema::create('mutasi_pindahs', function (Blueprint $table) {
            $table->id();

            $table->enum('tipe_pindah', [
                'domisili',
                'luar'
            ])->default('domisili');

            // data info domisili
            $table->date('tanggal_pindah');
            $table->foreignIdFor(Keluarga::class)->references('id')->on('keluargas')->onDelete('cascade');
            $table->foreignIdFor(Dusun::class)->references('id')->on('dusuns')->onDelete('cascade');
            $table->string('alamat_pindah');
            $table->string('alasan_pindah');

            // file pendukung
            $table->longText('foto_kk')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_pindahs');
    }
};
