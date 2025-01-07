<?php

namespace App\Filament\Resources\YearResource\Pages;

use App\Filament\Resources\YearResource;
use Filament\Resources\Pages\ListRecords;

class ListYears extends ListRecords
{
    public static $resource = YearResource::class;

    public static $title = 'Tahun';
}
