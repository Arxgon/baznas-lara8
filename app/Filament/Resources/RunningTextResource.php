<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RunningTextResource\Pages;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Table;
use App\Models\RunningText;
use Filament\Resources\Forms\Components;
use Filament\Resources\Tables\Columns;

class RunningTextResource extends Resource
{
    public static $model = RunningText::class;

    public static $navigationIcon = 'heroicon-o-rectangle-stack';

    public static $navigationLabel = 'Running Text';

    public static $label = 'Running Text';

    public static $navigationSort = 5;

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\Textarea::make('text')
                    ->label('Berita')
                    ->required(),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('text')
                ->label('Berita')
                    ->searchable()
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
            Pages\ListRunningTexts::routeTo('/', 'index'),
            Pages\CreateRunningText::routeTo('/create', 'create'),
            Pages\EditRunningText::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
