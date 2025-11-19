<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- BARU

class Artikel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_artikel';

    protected $fillable = [
        'id_kategori_artikel', // <-- PERUBAHAN: dari 'kategori'
        'judul',
        'isi',
        'path_foto',
    ];

    protected $table = 'artikels';

    /**
     * Define the relationship to the KategoriArtikel model.
     * Fixes: Call to undefined relationship [kategoriArtikel]
     */
    public function kategoriArtikel(): BelongsTo // <-- FUNGSI RELASI YANG HILANG
    {
        return $this->belongsTo(KategoriArtikel::class, 'id_kategori_artikel', 'id_kategori_artikel');
    }
}
