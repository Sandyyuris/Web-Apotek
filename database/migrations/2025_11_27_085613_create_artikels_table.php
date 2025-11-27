<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id('id_artikel');

            $table->unsignedBigInteger('id_kategori_artikel');

            $table->string('judul');
            $table->string('path_foto')->nullable();
            $table->longText('isi');
            $table->timestamps();

            $table->foreign('id_kategori_artikel')
                ->references('id_kategori_artikel')
                ->on('kategori_artikels')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
