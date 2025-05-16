<?php

use App\Models\Agama;
use App\Models\Kelamin;
use App\Models\Keluarga;
use App\Models\GolonganDarah;
use App\Models\PosisiKeluarga;
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
        Schema::create('mutasi_lahirs', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Keluarga::class)->references('id')->on('keluargas')->onDelete('cascade');
            $table->string('nik', 16)->nullable();
            $table->string('nama');
            $table->foreignIdFor(Kelamin::class);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->foreignIdFor(Agama::class);
            $table->foreignIdFor(GolonganDarah::class);
            $table->foreignIdFor(PosisiKeluarga::class);
            $table->enum('kelainan_fisik', [
                'ada',
                'tidak_ada'
            ])->default('tidak_ada');
            $table->enum('lahir_dari', [
                'pasangan_suami_istri',
                'anak_seorang_ibu'
            ])->default('pasangan_suami_istri');

            // file
            $table->string('surat_pernyataan_saksi')->nullable();
            $table->string('foto_kk')->nullable();
            $table->string('foto_surat_keterangan_kelahiran_dokter')->nullable();
            $table->string('foto_surat_dokter')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_lahirs');
    }
};
