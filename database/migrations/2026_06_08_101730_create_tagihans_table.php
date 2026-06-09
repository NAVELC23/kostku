<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('tagihans', function (Blueprint $table) {
        $table->id();
        
        // 1. Relasi ke tabel 'penghunis' milik Frensen (Tipe data Big Integer & Foreign Key)
        // Pastikan nama tabelnya di database Frensen adalah 'penghunis'
        $table->foreignId('id_penghuni')->constrained('penghunis')->onDelete('cascade');
        
        // 2. Kolom untuk mencatat bulan tagihan (Contoh: "Juni 2026")
        $table->string('bulan');
        
        // 3. Kolom nominal tagihan (Tipe data Integer karena uang)
        $table->integer('nominal_tagihan');
        
        // 4. Kolom status pembayaran (Isinya pilihan: Belum Lunas atau Lunas)
        $table->enum('status_bayar', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
        
        $table->timestamps(); // Otomatis membuat kolom created_at & updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
