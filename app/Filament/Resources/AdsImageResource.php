<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdsImageResource\Pages;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Table;

class AdsImageResource extends Resource
{
    public static $icon = 'heroicon-o-collection';

    public static $navigationGroup = 'Tambahan';


    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('name')
                    ->label('Nama Gambar')
                    ->required()
                    ->autofocus(),
                Components\FileUpload::make('path')->image()->directory('ads')
                    ->label('Unggah Gambar')
                    ->acceptedFileTypes(['image/jpeg', 'image/png']),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Image::make('path'),
                Columns\Text::make('name')
                    ->label('Nama Gambar')
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
            Pages\ListAdsImages::routeTo('/', 'index'),
            Pages\CreateAdsImage::routeTo('/create', 'create'),
            Pages\EditAdsImage::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
