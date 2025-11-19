<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriArtikel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kategori_artikel';
    protected $fillable = ['nama_kategori', 'slug'];
    protected $table = 'kategori_artikels';

    public function artikels(): HasMany
    {
        return $this->hasMany(Artikel::class, 'id_kategori_artikel', 'id_kategori_artikel');
    }
}
