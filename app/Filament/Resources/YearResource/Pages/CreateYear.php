<?php

namespace App\Filament\Resources\YearResource\Pages;

use App\Filament\Resources\YearResource;
use Filament\Resources\Pages\CreateRecord;

class CreateYear extends CreateRecord
{
    public static $resource = YearResource::class;

    public static $title = 'Tahun';
}
