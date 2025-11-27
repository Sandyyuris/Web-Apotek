<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_detail_transaksi';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jumlah',
        'harga_saat_transaksi',
        'subtotal',
    ];

    protected $table = 'detail_transaksis';

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
