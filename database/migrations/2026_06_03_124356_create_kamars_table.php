<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamars', function (Blueprint $table) {
            $table->id('id_kamar'); // PK sesuai ERD
            $table->string('nomor_kamar');
            $table->string('tipe'); // Standar, Deluxe, VIP (Sesuai Mockup)
            $table->integer('harga');
            $table->string('status')->default('Tersedia'); // Tersedia / Terisi
            $table->text('fasilitas')->nullable();
            $table->string('foto')->nullable(); // Tugas khusus upload foto
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
