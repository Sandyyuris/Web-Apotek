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
        // Semua definisi kolom dan foreign key harus di dalam closure ini
        Schema::create('artikels', function (Blueprint $table) {
            $table->id('id_artikel');

            // Kolom Foreign Key yang baru
            $table->unsignedBigInteger('id_kategori_artikel');
            // $table->string('kategori');

            $table->string('judul');
            $table->string('path_foto')->nullable();
            $table->longText('isi');
            $table->timestamps();

            // Definisi Foreign Key dipindahkan ke sini
            $table->foreign('id_kategori_artikel')
                ->references('id_kategori_artikel')
                ->on('kategori_artikels')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
