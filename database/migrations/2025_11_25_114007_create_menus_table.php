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
       Schema::create('menus', function (Blueprint $table) {
            $table->id('id_menu');
            $table->unsignedBigInteger('id_kategori');
            $table->string('nama_menu');
            $table->decimal('harga_menu', 12,2);
            $table->integer('stok_menu');
            $table->string('image_menu')->nullable();
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
