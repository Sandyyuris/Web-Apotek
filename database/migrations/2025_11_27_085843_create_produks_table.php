<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id('id_produk');
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_satuan');
            $table->string('nama_produk')->unique();
            $table->integer('stok')->default(0);
            $table->integer('harga_jual');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategoris')
                ->onDelete('restrict');

            $table->foreign('id_satuan')
                ->references('id_satuan')
                ->on('satuans')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
