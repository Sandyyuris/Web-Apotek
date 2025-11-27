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
        'id_kategori_artikel',
        'judul',
        'isi',
        'path_foto',
    ];

    protected $table = 'artikels';
    public function kategoriArtikel(): BelongsTo
    {
        return $this->belongsTo(KategoriArtikel::class, 'id_kategori_artikel', 'id_kategori_artikel');
    }
}
