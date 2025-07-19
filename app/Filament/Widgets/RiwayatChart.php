<?php

namespace App\Filament\Widgets;

use Flowframe\Trend\Trend;
use App\Models\RiwayatStok;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class RiwayatChart extends ChartWidget
{
    protected static ?string $heading = 'Riwayat Stok';

    protected function getData(): array
    {
        $start = now()->subYear();
        $end = now();

        $masuk = Trend::query(RiwayatStok::query()->where('tipe', 'masuk'))
            ->between(start: $start, end: $end)
            ->perMonth()
            ->sum('jumlah');

        $keluar = Trend::query(RiwayatStok::query()->where('tipe', 'keluar'))
            ->between(start: $start, end: $end)
            ->perMonth()
            ->sum('jumlah');

        return [
            'datasets' => [
                [
                    'label' => 'Barang Masuk',
                    'data' => $masuk->map(fn(TrendValue $value) => $value->aggregate),
                ],
                [
                    'label' => 'Barang Keluar',
                    'data' => $keluar->map(fn(TrendValue $value) => $value->aggregate),
                ]
            ],
            'labels' => $masuk->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
