<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YearResource\Pages;
use App\Filament\Resources\YearResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;
use App\Models\Year;

class YearResource extends Resource
{
    public static  $model = Year::class;

    public static  $navigationIcon = 'heroicon-o-rectangle-stack';

    public static  $navigationGroup = 'Kas';

    public static  $navigationLabel = 'Pengaturan Tahun';

    public static  $label = 'Tahun';

    public static $navigationSort = 1;


    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('year')
                    ->label('Tahun')
                    ->type('year')
                    ->required()
                    ->numeric()
                    ->default(date("Y"))
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('year')
                    ->label('Tahun')
                    ->sortable()
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
            Pages\ListYears::routeTo('/', 'index'),
            Pages\CreateYear::routeTo('/create', 'create'),
            Pages\EditYear::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
