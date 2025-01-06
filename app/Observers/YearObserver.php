<?php

namespace App\Observers;

use App\Models\Year;
use App\Models\Month;

class YearObserver
{
    /**
     * Handle the Year "created" event.
     */
    public function created(Year $year): void
    {
        // Loop through the months and create a record for each
        foreach (Year::$monthNames as $monthName) {
            Month::create([
                'month_name' => $monthName,
                'year_id' => $year->id,
                'collection' => 0, // Default collection value
                'distribution' => 0 // Default distribution value
            ]);
        }
    }

    /**
     * Handle the Year "updated" event.
     */
    public function updated(Year $year): void
    {
        //
    }

    /**
     * Handle the Year "deleted" event.
     */
    public function deleted(Year $year): void
    {
        //
    }

    /**
     * Handle the Year "restored" event.
     */
    public function restored(Year $year): void
    {
        //
    }

    /**
     * Handle the Year "force deleted" event.
     */
    public function forceDeleted(Year $year): void
    {
        //
    }
}
