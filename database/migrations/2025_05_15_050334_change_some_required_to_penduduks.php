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
            $table->string('alamat')->nullable()->change();
            $table->string('nik_ayah', 16)->nullable()->change();
            $table->string('nama_ayah')->nullable()->change();
            $table->string('nik_ibu', 16)->nullable()->change();
            $table->string('nama_ibu')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            //
        });
    }
};
