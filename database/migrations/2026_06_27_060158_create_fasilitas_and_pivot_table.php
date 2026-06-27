<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Hapus kolom fasilitas lama dari tabel kamars
        Schema::table('kamars', function (Blueprint $table) {
            $table->dropColumn('fasilitas');
        });

        // 2. Buat tabel master fasilitas
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id(); // Primary key: id
            $table->string('nama_fasilitas');
            $table->timestamps();
        });

        // 3. Buat tabel pivot fasilitas_kamar
        Schema::create('fasilitas_kamar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kamar_id');
            $table->unsignedBigInteger('fasilitas_id');

            // Foreign keys dengan cascade delete
            $table->foreign('kamar_id')->references('id_kamar')->on('kamars')->onDelete('cascade');
            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_kamar');
        Schema::dropIfExists('fasilitas');
        
        Schema::table('kamars', function (Blueprint $table) {
            $table->text('fasilitas')->nullable();
        });
    }
};