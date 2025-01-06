<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AttendanceLeader;

class AttendanceLeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['position' => 'KETUA', 'attendance_status' => AttendanceLeader::STATUS_PRESENT],
            ['position' => 'WAKIL KETUA I', 'attendance_status' => AttendanceLeader::STATUS_ABSENT],
            ['position' => 'WAKIL KETUA II', 'attendance_status' => AttendanceLeader::STATUS_OFFICIAL_DUTY],
            ['position' => 'WAKIL KETUA III', 'attendance_status' => AttendanceLeader::STATUS_OFFICIAL_DUTY],
            ['position' => 'WAKIL KETUA IV', 'attendance_status' => AttendanceLeader::STATUS_OFFICIAL_DUTY],
            ['position' => 'SEKRETARIS', 'attendance_status' => AttendanceLeader::STATUS_OFFICIAL_DUTY],
        ];

        foreach ($data as $item) {
            AttendanceLeader::create($item);
        }
    }
}
