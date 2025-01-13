<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Year;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Facades\Log;

class YearDataController extends Controller
{
    /**
     * Retrieve monthly collection data for a specific year.
     *
     * @param  int  $year
     * @return JsonResponse
     */
    public function getMonthlyCollections(int $year): JsonResponse
    {
        try {
            // Find the year record
            $yearRecord = Year::where('year', $year)->first();

            if (!$yearRecord) {
                // Return 404 if the year is not found
                return response()->json(['message' => 'Year not found'], 404);
            }

            // Retrieve monthly collections for the specified year
            $monthlyCollection = $yearRecord->months()
                ->orderByRaw("FIELD(month_name, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
                ->pluck('collection', 'month_name');

            // Format data for ApexCharts
            $formattedData = [
                'categories' => $monthlyCollection->keys()->all(),
                'collection' => $monthlyCollection->values()->all(),
            ];

            return response()->json($formattedData);
        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error("Error fetching monthly collections for year {$year}: " . $e->getMessage());

            // Return a 500 response with an error message
            return response()->json(['message' => 'An error occurred while fetching data'], 500);
        }
    }

    /**
     * Retrieve monthly distribution data for a specific year.
     *
     * @param  int  $year
     * @return JsonResponse
     */
    public function getMonthlyDistributions(int $year): JsonResponse
    {
        try {
            // Find the year record
            $yearRecord = Year::where('year', $year)->first();

            if (!$yearRecord) {
                // Return 404 if the year is not found
                return response()->json(['message' => 'Year not found'], 404);
            }

            // Retrieve monthly distributions for the specified year
            $monthlyDistribution = $yearRecord->months()
                ->orderByRaw("FIELD(month_name, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
                ->pluck('distribution', 'month_name');

            // Format data for ApexCharts
            $formattedData = [
                'categories' => $monthlyDistribution->keys()->all(),
                'distribution' => $monthlyDistribution->values()->all(),
            ];

            return response()->json($formattedData);
        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error("Error fetching monthly distribution for year {$year}: " . $e->getMessage());

            // Return a 500 response with an error message
            return response()->json(['message' => 'An error occurred while fetching data'], 500);
        }
    }

    /**
     * Retrieve monthly data (month names, collections, and distributions) for a specific year.
     * including total collection and distribution.
     *
     * @param  int  $year
     * @return JsonResponse
     */
    public function getMonthlyDataFull(int $year): JsonResponse
    {
        try {
            // Find the year record
            $yearRecord = Year::where('year', $year)->first();

            if (!$yearRecord) {
                // Return 404 if the year is not found
                return response()->json(['message' => 'Year not found'], 404);
            }

            // Retrieve months, collections, and distributions for the specified year
            $monthlyData = $yearRecord->months()
                ->orderByRaw("FIELD(month_name, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
                ->get(['month_name', 'collection', 'distribution']);

            // Calculate total collection and distribution
            $totalCollection = $monthlyData->sum('collection');
            $totalDistribution = $monthlyData->sum('distribution');

            // Format data for the response
            $formattedData = [
                'months' => $monthlyData->pluck('month_name')->all(),
                'collections' => $monthlyData->pluck('collection')->all(),
                'distributions' => $monthlyData->pluck('distribution')->all(),
                'total_collection' => $totalCollection,
                'total_distribution' => $totalDistribution,
            ];

            return response()->json($formattedData);
        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error("Error fetching monthly data for year {$year}: " . $e->getMessage());

            // Return a 500 response with an error message
            return response()->json(['message' => 'An error occurred while fetching data'], 500);
        }
    }

    private function getMonthsArray(): array
    {
        return [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
    }

    public function getMonthlyData(int $year): JsonResponse
    {
        try {
            $currentMonth = date('n');

            if ($currentMonth == 1) {
                $yearToFetch = $year - 1;
            } else {
                $yearToFetch = $year;
            }

            $yearRecord = Year::where('year', $yearToFetch)->first();

            if (!$yearRecord) {
                return response()->json(['message' => 'Year not found'], 404);
            }

            $monthsArray = $this->getMonthsArray();

            if ($currentMonth == 1) {
                $monthlyData = $yearRecord->months()
                    ->orderByRaw("FIELD(month_name, '" . implode("', '", $monthsArray) . "')")
                    ->get(['month_name', 'collection', 'distribution']);
            } else {
                // Ambil data bulan hingga bulan sebelum bulan saat ini
                $monthlyData = $yearRecord->months()
                    ->whereIn('month_name', array_slice($monthsArray, 0, $currentMonth - 1))
                    ->orderByRaw("FIELD(month_name, '" . implode("', '", $monthsArray) . "')")
                    ->get(['month_name', 'collection', 'distribution']);
            }

            // $totalCollection = $monthlyData->sum('collection');
            // $totalDistribution = $monthlyData->sum('distribution');

            $accumulatedCollections = [];
            $accumulatedDistributions = [];
            $totalCollection = 0;
            $totalDistribution = 0;

            foreach ($monthlyData as $month) {
                $totalCollection += $month->collection;
                $totalDistribution += $month->distribution;

                $accumulatedCollections[] = $totalCollection;
                $accumulatedDistributions[] = $totalDistribution;
            }

            $formattedData = [
                'months' => $monthlyData->pluck('month_name')->all(),
                'collections' => $monthlyData->pluck('collection')->all(),
                'distributions' => $monthlyData->pluck('distribution')->all(),
                'accumulatedCollections' => $accumulatedCollections,
                'accumulatedDistributions' => $accumulatedDistributions,
                'total_collection' => $totalCollection,
                'total_distribution' => $totalDistribution,
            ];

            return response()->json($formattedData);
        } catch (Exception $e) {
            Log::error("Error fetching monthly data for year {$year}: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching data'], 500);
        }
    }


}
