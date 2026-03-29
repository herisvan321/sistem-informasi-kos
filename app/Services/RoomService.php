<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Listing;

class RoomService
{
    public function getAllForListing(Listing $listing)
    {
        return $listing->rooms()->latest()->get();
    }

    public function create(Listing $listing, array $data)
    {
        return $listing->rooms()->create($data);
    }

    public function update(Room $room, array $data)
    {
        $room->update($data);
        return $room;
    }

    public function delete(Room $room)
    {
        return $room->delete();
    }

    public function toggleStatus(Room $room)
    {
        $room->status = ($room->status === 'Available') ? 'Full' : 'Available';
        $room->save();
        return $room;
    }
}
