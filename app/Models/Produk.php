<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_produk'; // <-- GANTI DARI id_obat

    protected $fillable = [
        'id_kategori', // <-- BARU
        'nama_produk',
        'satuan',
        'stok',
        'harga_jual',
        'deskripsi',
    ];

    protected $table = 'produks'; // <-- GANTI DARI obats

    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_produk', 'id_produk');
    }

    public function kategori(): BelongsTo // <-- BARU
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
