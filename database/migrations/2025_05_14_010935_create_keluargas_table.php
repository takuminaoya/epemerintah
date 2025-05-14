<?php

use App\Models\Dusun;
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
        Schema::create('keluargas', function (Blueprint $table) {
            $table->id();
            $table->uuid();

            $table->string("nomor", 16)->unique();

            // Domisili, update domisili akan update seluruh keluarga
            $table->string('provinsi')->default('bali');
            $table->string('kabupaten')->default('badung');
            $table->string('kecamatan')->default('kuta selatan');
            $table->string('kelurahan')->default('desa ungasan');
            $table->string('kode_pos')->default('80364');
            $table->foreignIdFor(Dusun::class);

            $table->string('alamat');

            // file
            $table->longText('foto_kk');

            $table->enum('status', [
                'aktif',
                'tidak aktif'
            ])->default('aktif');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluargas');
    }
};
