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
            $table->string('biaya_pengiriman')->nullable();
            $table->string('tipe_pengiriman')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->string('metode_pembayaran');
            $table->string('status_pembayaran')->default('Pending');
            $table->string('status_pesanan')->default('Baru');
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
