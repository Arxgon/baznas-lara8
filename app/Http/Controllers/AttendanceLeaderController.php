<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\AttendanceLeader;
use Illuminate\Http\JsonResponse;

class AttendanceLeaderController extends Controller
{
    /**
         * Get all attendance leader data.
         *
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            try {
                // Retrieve all attendance data
                $attendanceLeaders = AttendanceLeader::all();

                // Return success response with data
                return response()->json([
                    'success' => true,
                    'data' => $attendanceLeaders,
                ], 200);

            } catch (Exception $e) {
                // Return error response if an exception occurs
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve attendance data',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
}
