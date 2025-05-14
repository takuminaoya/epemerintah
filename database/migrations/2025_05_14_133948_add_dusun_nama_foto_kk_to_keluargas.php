<?php

use App\Models\Dusun;
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
        Schema::table('keluargas', function (Blueprint $table) {
            $table->foreignIdFor(Dusun::class)->nullable()->change();
            $table->string('nama_dusun')->after('dusun_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluargas', function (Blueprint $table) {
            $table->dropColumn('nama_dusun');
        });
    }
};
