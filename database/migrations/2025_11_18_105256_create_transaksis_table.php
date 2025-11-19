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
            $table->integer('biaya_pengiriman')->default(0); // <-- BARU
            $table->string('tipe_pengiriman')->default('Diambil di Apotek'); // <-- BARU
            $table->text('alamat_pengiriman')->nullable(); // <-- BARU
            $table->string('metode_pembayaran')->default('Cash'); // <-- BARU
            $table->string('status_pembayaran')->default('Pending'); // Ubah default menjadi Pending

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
