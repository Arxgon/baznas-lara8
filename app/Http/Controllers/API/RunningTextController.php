<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\RunningText;
use Illuminate\Http\JsonResponse;

class RunningTextController extends Controller
{
    /**
         * Get all news data.
         *
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            try {
                // Retrieve all news data
                $news = RunningText::all();

                // Return success response with data
                return response()->json([
                    'success' => true,
                    'data' => $news,
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
