<?php

namespace App\Filament\Resources\AttendanceLeaderResource\Pages;

use App\Filament\Resources\AttendanceLeaderResource;
use Filament\Resources\Pages\ListRecords;

class ListAttendanceLeaders extends ListRecords
{
    public static $resource = AttendanceLeaderResource::class;

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
