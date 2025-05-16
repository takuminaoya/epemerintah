<?php

use App\Models\Dusun;
use App\Models\Keluarga;
use App\Models\MutasiLahir;
use App\Models\Pekerjaan;
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
        Schema::create('mutasi_lahir_anggotas', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(MutasiLahir::class)->references('id')->on('mutasi_lahirs')->onDelete('cascade');
            $table->foreignIdFor(Keluarga::class)->references('id')->on('keluargas')->onDelete('cascade');

            $table->enum('tipe_anggota', [
                'orang_tua',
                'saksi'
            ])->default('orang_tua');

            $table->enum('tipe_pasangan', [
                'ayah',
                'ibu',
                'saksi'
            ])->default('ayah');

            $table->string('nik', 16)->nullable();
            $table->string('nama');
            $table->foreignIdFor(Pekerjaan::class);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->string('alamat');
            $table->foreignIdFor(Dusun::class);

            $table->enum('status_domisili', [
                'dalam',
                'luar'
            ])->default('dalam');

            $table->foreignIdFor(Penduduk::class)->nullable();
            $table->string('foto_ktp')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_lahir_anggotas');
    }
};
