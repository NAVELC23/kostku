<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penghunis', function (Blueprint $table) {
            $table->id('id_penghuni');
            $table->foreignId('id_user')->constrained('users', 'id')->onDelete('cascade');
            $table->unsignedBigInteger('id_kamar')->nullable();
            $table->foreign('id_kamar')->references('id_kamar')->on('kamars')->onDelete('set null');
            $table->date('tanggal_masuk');
            $table->enum('status_penghuni', ['aktif', 'nonaktif'])->default('aktif');
            $table->date('tanggal_keluar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penghunis');
    }
};