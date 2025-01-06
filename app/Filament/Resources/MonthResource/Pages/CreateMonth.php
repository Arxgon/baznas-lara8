<?php

namespace App\Filament\Resources\MonthResource\Pages;

use App\Filament\Resources\MonthResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMonth extends CreateRecord
{
    public static $resource = MonthResource::class;

    protected function afterFill()
    {
        if ($this->record->collection) {
            $this->record->collection = number_format($this->record->collection, 0, ',', '.');
        }
    }

    protected function beforeSave()
    {
        if ($this->record->collection) {
            $this->record->collection = str_replace('.', '', $this->record->collection);
        }
    }
}
