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

    //function untuk generate kode_barang secara otomatis
    protected static function booted()
    {
        static::creating(function ($barang) {
            $barang->kode_barang = 'BRG-' . now()->format('YmdHis');
        });
    }
}
