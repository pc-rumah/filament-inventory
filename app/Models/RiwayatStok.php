<?php

namespace App\Models;

use App\Models\User;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    protected $guarded = ['id'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    protected static function booted()
    {
        //fungsi untuk mengubah stok barang
        static::creating(function ($riwayat) {
            $barang = $riwayat->barang;

            if ($riwayat->tipe === 'masuk') {
                $barang->stok += $riwayat->jumlah;
            } elseif ($riwayat->tipe === 'keluar') {
                $barang->stok -= $riwayat->jumlah;
                if ($barang->stok < $riwayat->jumlah) {
                    throw new \Exception('Stok tidak cukup.');
                }
                $barang->stok -= $riwayat->jumlah;
            }
            $barang->save();
        });

        //fungsi untuk mengubah stok barang saat riwayat stok dihapus
        static::deleting(function ($riwayat) {
            $barang = $riwayat->barang;

            if ($riwayat->tipe === 'masuk') {
                $barang->stok -= $riwayat->jumlah;
            } elseif ($riwayat->tipe === 'keluar') {
                $barang->stok += $riwayat->jumlah;
            }
            $barang->save();
        });
    }
}
