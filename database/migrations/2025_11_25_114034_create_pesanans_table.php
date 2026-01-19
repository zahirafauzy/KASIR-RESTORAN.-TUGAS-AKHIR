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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->string('nama_customer');
            $table->string('catatan')->nullable(); // ⬅️ TAMBAHAN
            $table->integer('no_meja');
            $table->integer('jumlah_item');
            $table->decimal('total_bayar', 12, 2);

            $table->decimal('uang_bayar', 12, 2);
            $table->decimal('uang_kembalian', 12, 2);

            $table->dateTime('waktu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
