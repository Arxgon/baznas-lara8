<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
         * Get first video data.
         *
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            try {
                // Retrieve first video data
                $video = Video::orderBy('created_at', 'desc')->first();

                // Return success response with data
                return response()->json([
                    'success' => true,
                    'data' => $video
                ], 200);

            } catch (Exception $e) {
                // Return error response if an exception occurs
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve news data',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
}
