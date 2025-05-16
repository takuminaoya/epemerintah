<?php

namespace App\Filament\Resources\PendudukResource\Widgets;

use App\Models\MutasiKematian;
use App\Models\MutasiLahir;
use App\Models\MutasiPindahPenduduk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AktifOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pindah Domisili', MutasiPindahPenduduk::count() . ' Orang')
            ->icon('heroicon-o-truck'),
            Stat::make('Kematian', MutasiKematian::count() . ' Orang')
            ->icon('tabler-grave-2'),
            Stat::make('Kelahiran', MutasiLahir::count() . ' Orang')
            ->icon('tabler-plus'),
        ];
    }
}
