<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\AdsImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AdsImageController extends Controller
{
    /**
         * Get all image data.
         *
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            try {
                // Retrieve all image data
                $image = AdsImage::all();

                // Return success response with data
                return response()->json([
                    'success' => true,
                    'data' => $image
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
