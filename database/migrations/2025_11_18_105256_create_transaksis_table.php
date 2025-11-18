<?php
// ... (isi file sama seperti sebelumnya)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_users')->nullable();

            $table->string('kode_transaksi')->unique();
            $table->integer('total_harga');
            $table->string('status_pembayaran')->default('Lunas');

            $table->timestamps();

            $table->foreign('id_users')
                ->references('id_users')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
