<?php

use App\Models\GolonganDarah;
use App\Models\Keluarga;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\PosisiKeluarga;
use App\Models\StatusPernikahan;
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
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->foreignIdFor(Keluarga::class)->references('id')->on('keluargas')->onDelete('cascade');

            $table->string('nik', 16);
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->string('telp')->nullable();

            $table->string('alamat');

            // detail keluarga
            $table->string('nik_ayah', 16);
            $table->string('nama_ayah');
            $table->string('nik_ibu', 16);
            $table->string('nama_ibu');

            // kelainan
            $table->tinyInteger('kelainan_fisik')->default(0);

            $table->foreignIdFor(GolonganDarah::class)->nullable();
            $table->foreignIdFor(StatusPernikahan::class)->nullable();
            $table->foreignIdFor(Pendidikan::class)->nullable();
            $table->foreignIdFor(Pekerjaan::class)->nullable();
            $table->foreignIdFor(PosisiKeluarga::class)->nullable();

            $table->enum('status', [
                'aktif',
                'tidak aktif',
                'pindah',
                'meninggal'
            ])->default('aktif');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};
