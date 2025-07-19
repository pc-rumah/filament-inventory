<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriBarang::create(['nama_kategori' => 'Elektronik']);
        KategoriBarang::create(['nama_kategori' => 'Makanan']);
        KategoriBarang::create(['nama_kategori' => 'Minuman']);
        KategoriBarang::create(['nama_kategori' => 'Perabotan']);

        $this->command->info('Kategori Barang telah diisi');
    }
}
