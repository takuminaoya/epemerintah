<?php

namespace App\Base;

use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class MasterForm
{
    public static function basic_form()
    {
        return [
            TextInput::make('nama')
                ->required(),
        ];
    }

    public static function basic_column()
    {
        return [
            TextColumn::make('nama')
                ->searchable(),
            TextColumn::make('created_at')
                ->label('Dibuat pada')
                ->since()
                ->dateTimeTooltip(),
            TextColumn::make('updated_at')
                ->label('Terakhir Diperbarui')
                ->since()
                ->dateTimeTooltip()
        ];
    }
}
