<?php

namespace App\Filament\Resources\AttendanceLeaderResource\Pages;

use App\Filament\Resources\AttendanceLeaderResource;
use Filament\Resources\Pages\EditRecord;

class EditAttendanceLeader extends EditRecord
{
    public static $resource = AttendanceLeaderResource::class;

    public static $title = 'Absensi Pimpinan';

    public function canDelete()
    {
        return false;
    }
}
