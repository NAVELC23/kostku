<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perbaikans', function (Blueprint $table) {
            $table->id();

            // Relasi ke penghuni (konsisten dengan tagihan)
            $table->unsignedBigInteger('id_penghuni');
            $table->foreign('id_penghuni')->references('id_penghuni')->on('penghunis')->onDelete('cascade');

            $table->string('judul');                       
            $table->string('kategori');                    
            $table->text('deskripsi');                     
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
            $table->date('tanggal_lapor')->default(now()); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perbaikans');
    }
};