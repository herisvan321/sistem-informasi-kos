<?php

namespace App\Observers;

use App\Models\Listing;

class ListingObserver
{
    /**
     * Handle the Listing "creating" event.
     */
    public function creating(Listing $listing): void
    {
        $listing->slug = \Illuminate\Support\Str::slug($listing->name) . '-' . substr(uniqid(), -5);
    }

    /**
     * Handle the Listing "updating" event.
     */
    public function updating(Listing $listing): void
    {
        if ($listing->isDirty('name')) {
            $listing->slug = \Illuminate\Support\Str::slug($listing->name) . '-' . substr(uniqid(), -5);
        }
    }

    /**
     * Handle the Listing "created" event.
     */
    public function created(Listing $listing): void
    {
        //
    }

    /**
     * Handle the Listing "updated" event.
     */
    public function updated(Listing $listing): void
    {
        //
    }

    /**
     * Handle the Listing "deleted" event.
     */
    public function deleted(Listing $listing): void
    {
        //
    }

    /**
     * Handle the Listing "restored" event.
     */
    public function restored(Listing $listing): void
    {
        //
    }

    /**
     * Handle the Listing "force deleted" event.
     */
    public function forceDeleted(Listing $listing): void
    {
        //
    }
}
