<?php

namespace App\Models;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    protected $fillable = ['nama_kategori'];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}
