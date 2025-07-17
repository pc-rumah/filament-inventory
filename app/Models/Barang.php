<?php

namespace App\Models;

use App\Models\RiwayatStok;
use App\Models\KategoriBarang;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    public function riwayatStok()
    {
        return $this->hasMany(RiwayatStok::class, 'barang_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }
}
