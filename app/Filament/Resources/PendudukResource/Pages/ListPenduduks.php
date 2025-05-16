<?php

namespace App\Filament\Resources\PendudukResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PendudukResource;
use App\Filament\Resources\PendudukResource\Widgets\AktifOverview;
use App\Models\Penduduk;

class ListPenduduks extends ListRecords
{
    protected static string $resource = PendudukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AktifOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua')
                ->icon('tabler-checks'),
            'aktif' => Tab::make('Aktif')
                ->icon('tabler-check')
                ->badge(
                    Penduduk::where('status', 'aktif')->count()
                )
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'aktif')),
            'tidak_aktif' => Tab::make('Tidak Aktif')
                ->icon('heroicon-o-x-mark')
                ->badge(
                    Penduduk::where('status', 'tidak aktif')->count()
                )
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'tidak aktif')),
            'meninggal' => Tab::make('Meninggal')
                ->icon('tabler-grave-2')
                ->badge(
                    Penduduk::where('status', 'meninggal')->count()
                )
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'meninggal')),
            'lahir' => Tab::make('Lahiran')
                ->icon('tabler-diaper')
                ->badge(
                    Penduduk::where('status', 'lahir')->count()
                )
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'lahir')),
            'pindah' => Tab::make('Pindah')
                ->icon('tabler-truck')
                ->badge(
                    Penduduk::where('status', 'pindah')->count()
                )
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pindah')),
        ];
    }

}
