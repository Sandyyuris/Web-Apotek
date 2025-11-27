<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Pastikan ini ada
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_kategori',
        'id_satuan',
        'nama_produk',
        'stok',
        'harga_jual',
        'deskripsi',
    ];

    protected $table = 'produks';

    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_produk', 'id_produk');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Define the relationship to the Satuan model.
     * Fixes: Call to undefined relationship [satuan]
     */
    public function satuan(): BelongsTo // <-- FUNGSI RELASI YANG HILANG
    {
        // Menghubungkan Produk ke Satuan menggunakan id_satuan
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id_satuan');
    }
}
