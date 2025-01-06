<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLeader extends Model
{
    use HasFactory;

    protected $table = 'attendance_leaders';

    protected $fillable = [
        'position',
        'attendance_status',
    ];

    const STATUS_PRESENT = 'ada';
    const STATUS_ABSENT = 'tidak ada';
    const STATUS_OFFICIAL_DUTY = 'dinas luar';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PRESENT,
            self::STATUS_ABSENT,
            self::STATUS_OFFICIAL_DUTY,
        ];
    }
}
