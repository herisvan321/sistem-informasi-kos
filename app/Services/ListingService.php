<?php

namespace App\Services;

use App\Models\Listing;

class ListingService extends BaseService
{
    public function __construct(Listing $listing)
    {
        parent::__construct($listing);
    }

    public function approve(string $id): bool
    {
        return $this->update($id, ['status' => 'Approved']);
    }

    public function reject(string $id, array $details = []): bool
    {
        return $this->update($id, array_merge(['status' => 'Rejected'], $details));
    }

    public function togglePremium(string $id): bool
    {
        $listing = $this->find($id);
        return $listing->update(['is_premium' => !$listing->is_premium]);
    }
}
