<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BarangTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('barang', Barang::query()->count()),
        ];
    }
}
