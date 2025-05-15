<?php

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
        Schema::table('penduduks', function (Blueprint $table) {
            $table->string('kewarganegaraan')->default('WNI');
            $table->string('negara')->default('Indonesia');
            $table->string('no_kitap')->nullable();
            $table->string('no_paspor')->nullable();
            $table->date('tanggal_perkawinan')->nullable()->after('status_pernikahan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            $table->dropColumn('kewarganegaraan');
            $table->dropColumn('negara');
            $table->dropColumn('no_kitap');
            $table->dropColumn('no_paspor');
            $table->dropColumn('tanggal_perkawinan');
        });
    }
};
