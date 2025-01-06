<?php

namespace App\Filament\Resources\MonthResource\Pages;

use App\Filament\Resources\MonthResource;
use Filament\Resources\Pages\ListRecords;

class ListMonths extends ListRecords
{
    public static $resource = MonthResource::class;

    public function canCreate()
    {
        return false;
    }

    public function canDelete()
    {
        return false;
    }

    public function canDeleteSelected()
    {
        return false;
    }
}
