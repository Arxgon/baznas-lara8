<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Filament\Resources\VideoResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;
use App\Models\Video;

class VideoResource extends Resource
{
    public static $icon = 'heroicon-o-collection';
    public static $model = Video::class;

    public static $navigationIcon = 'heroicon-o-rectangle-stack';

    public static $navigationGroup = 'Tambahan';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\FileUpload::make('attachment')
                ->acceptedFileTypes([
                        'video/mp4',
                        'video/webm',
                        'video/ogg',
                        'video/avi',
                        'video/mkv',
                        'video/flv'
                    ])
                ->directory('vid')
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                //
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
            Pages\ListVideos::routeTo('/', 'index'),
            Pages\CreateVideo::routeTo('/create', 'create'),
            Pages\EditVideo::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
