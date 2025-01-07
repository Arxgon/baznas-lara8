<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonthResource\Pages;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Table;
use App\Models\Month;
use Illuminate\Database\Eloquent\Model;

class MonthResource extends Resource
{
    public static $model = Month::class;

    public static $navigationIcon = 'heroicon-o-rectangle-stack';

    public static $navigationLabel = 'Pengaturan Bulan';

    public static $label = 'Kas Per Bulan';

    public static $navigationSort = 3;

    public static function canCreate(): bool
   {
        return false;
   }

   public static function canDelete(Model $record): bool
   {
        return false;
   }

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('month_name')
                    ->label('Penghimpunan dan Pendistribusian untuk Bulan')
                    ->disabled(true)
                    ->required(),
                Components\TextInput::make('collection')
                    ->label('Penghimpunan')
                    ->prefix('Rp')
                    ->required(),
                Components\TextInput::make('distribution')
                    ->prefix('Rp')
                    ->label('Pendistribusian')
                    ->required(),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('month_name')
                ->label('Bulan')
                    ->searchable(),
                Columns\Text::make('collection')
                    ->label('Penghimpunan (Rp)')
                    ->currency('Rp', ',', '.', 0),

                Columns\Text::make('distribution')
                    ->label('Pendistribusian (Rp)')
                    ->currency('Rp', ',', '.', 0),

               Columns\Text::make('year.year')
                ->label('Tahun')
                    ->sortable(),

            ])
            ->filters([
                //
            ]);
    }

    public static function relations()
    {
        return [
            //
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListMonths::routeTo('/', 'index'),
            Pages\CreateMonth::routeTo('/create', 'create'),
            Pages\EditMonth::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
