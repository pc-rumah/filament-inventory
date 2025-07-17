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
}
