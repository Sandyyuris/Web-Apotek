<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Satuan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_satuan';
    protected $fillable = ['nama_satuan'];
    protected $table = 'satuans';

    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class, 'id_satuan', 'id_satuan');
    }
}
