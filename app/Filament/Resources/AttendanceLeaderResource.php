<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceLeaderResource\Pages;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Table;
use App\Models\AttendanceLeader;
use Filament\Resources\Tables\Columns;

class AttendanceLeaderResource extends Resource
{
    public static $model = AttendanceLeader::class;

    public static $icon = 'heroicon-o-collection';

    public static $navigationGroup = 'Absensi';

    public static $navigationLabel = 'Absensi Pimpinan';

    public static $label = 'Absensi Pimpinan';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('position')
                    ->label('Posisi')
                    ->disabled(),
                Components\Select::make('attendance_status')
                    ->label('Status Absensi')
                    ->options(array_combine(AttendanceLeader::getStatusOptions(), AttendanceLeader::getStatusOptions()))
                    ->required(),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('position')
                    ->label('Posisi')
                    ->searchable(),
                Columns\Text::make('attendance_status')
                    ->label('Status Absensi'),
                // Tables\Columns\TextColumn::make('attendance_status')
                //     ->label('Status Absensi'),
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
            Pages\ListAttendanceLeaders::routeTo('/', 'index'),
            Pages\CreateAttendanceLeader::routeTo('/create', 'create'),
            Pages\EditAttendanceLeader::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
