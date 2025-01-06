<?php

namespace App\Filament\Resources\MonthResource\Pages;

use App\Filament\Resources\MonthResource;
use Filament\Resources\Pages\EditRecord;

class EditMonth extends EditRecord
{
    public static $resource = MonthResource::class;

    public function canDelete()
    {
        return false;
    }

    protected function afterFill()
    {
        if ($this->record->collection) {
            $this->record->collection = number_format($this->record->collection, 0, ',', '.');
        }

        if ($this->record->distribution) {
            $this->record->distribution = number_format($this->record->distribution, 0, ',', '.');
        }
    }

    protected function beforeSave()
    {
        if ($this->record->collection) {
            $this->record->collection = str_replace('.', '', $this->record->collection);
        }

        if ($this->record->distribution) {
            $this->record->distribution = str_replace('.', '', $this->record->distribution);
        }
    }

    protected function afterSave()
    {
        if ($this->record->collection) {
            $this->record->collection = number_format($this->record->collection, 0, ',', '.');
        }

        if ($this->record->distribution) {
            $this->record->distribution = number_format($this->record->distribution, 0, ',', '.');
        }
    }
}
