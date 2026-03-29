<?php

namespace App\Http\Controllers\PemilikKos;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Room;
use App\Http\Requests\PemilikKos\RoomRequest;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index(Listing $listing)
    {
        $this->authorizeOwner($listing);
        $rooms = $this->roomService->getAllForListing($listing);
        return view('pemilik_kos.rooms.index', compact('listing', 'rooms'));
    }

    public function store(RoomRequest $request, Listing $listing)
    {
        $this->authorizeOwner($listing);
        $data = $request->validated();
        
        $this->roomService->create($listing, $data);

        return redirect()->back()->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function update(RoomRequest $request, Room $room)
    {
        $this->authorizeOwner($room->listing);
        $data = $request->validated();
        
        $this->roomService->update($room, $data);

        return redirect()->back()->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $this->authorizeOwner($room->listing);
        $this->roomService->delete($room);

        return redirect()->back()->with('success', 'Kamar berhasil dihapus.');
    }

    public function toggleStatus(Room $room)
    {
        $this->authorizeOwner($room->listing);
        $this->roomService->toggleStatus($room);

        return redirect()->back()->with('success', 'Status kamar berhasil diubah.');
    }

    protected function authorizeOwner(Listing $listing)
    {
        if ($listing->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
