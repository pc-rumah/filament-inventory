<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Satuan::create(['nama_satuan' => 'Pcs']);
        Satuan::create(['nama_satuan' => 'Ltr']);
        Satuan::create(['nama_satuan' => 'Unit']);
        Satuan::create(['nama_satuan' => 'Kg']);
    }
}
