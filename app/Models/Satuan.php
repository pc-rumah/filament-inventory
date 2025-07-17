<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $guarded = ['id'];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'satuan_id');
    }
}
