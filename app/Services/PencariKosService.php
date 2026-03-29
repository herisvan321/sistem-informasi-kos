<?php

namespace App\Services;

use App\Models\Listing;
use App\Models\Favorite;
use App\Models\Transaction;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PencariKosService
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Search listings with filters.
     */
    public function searchListings(array $filters = [])
    {
        $query = Listing::where('status', 'Approved');

        if (isset($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('city', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('district', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Prioritize premium listings and then latest
        return $query->orderBy('is_premium', 'desc')->latest()->paginate(12);
    }

    /**
     * Toggle favorite status.
     */
    public function toggleFavorite(string $listingId, string $userId)
    {
        $favorite = Favorite::where('user_id', $userId)
                            ->where('listing_id', $listingId)
                            ->first();

        if ($favorite) {
            $favorite->delete();
            return ['status' => 'removed', 'message' => 'Dihapus dari favorit'];
        }

        Favorite::create([
            'user_id' => $userId,
            'listing_id' => $listingId,
        ]);

        return ['status' => 'added', 'message' => 'Ditambahkan ke favorit'];
    }

    /**
     * Get user favorites with listing details.
     */
    public function getFavorites(string $userId)
    {
        return Favorite::with(['listing' => function($q) {
                        $q->with('rooms');
                    }])
                    ->where('user_id', $userId)
                    ->latest()
                    ->get();
    }

    /**
     * Create a new booking request.
     */
    public function createBooking(array $data, string $userId)
    {
        $listing = Listing::findOrFail($data['listing_id']);
        $room = Room::findOrFail($data['room_id']);

        return Transaction::create([
            'user_id' => $userId,
            'listing_id' => $listing->id,
            'room_id' => $room->id,
            'amount' => $listing->price, // Simplified: uses listing price
            'status' => 'Pending',
            'payment_method' => $data['payment_method'] ?? 'Transfer Bank',
            'check_in_date' => $data['check_in_date'],
            'duration_months' => $data['duration_months'],
            'notes' => $data['notes'] ?? null,
        ]);
    }

    /**
     * Send an inquiry to a property owner.
     */
    public function sendInquiry(array $data, string $userId)
    {
        $listing = Listing::findOrFail($data['listing_id']);

        $inquiry = \App\Models\Inquiry::create([
            'listing_id' => $listing->id,
            'sender_id' => $userId,
            'receiver_id' => $listing->owner_id,
            'message' => $data['message'],
            'status' => 'Unread'
        ]);

        // Notify the listing owner about the new inquiry
        $sender = \App\Models\User::find($userId);
        if ($listing->user) {
            $listing->user->notify(new \App\Notifications\GeneralNotification(
                'Pesan Baru Masuk',
                "Anda menerima pesan dari {$sender->name} mengenai properti \"{$listing->name}\".",
                null
            ));
        }

        return $inquiry;
    }

    /**
     * Upload payment proof for a transaction.
     */
    public function uploadPaymentProof(string $transactionId, $file)
    {
        $transaction = Transaction::findOrFail($transactionId);

        if ($file) {
            $path = $this->imageService->convertToWebp($file, 'payment_proofs');
            
            if ($path) {
                // Delete old proof if it exists
                if ($transaction->payment_proof) {
                    Storage::disk('public')->delete($transaction->payment_proof);
                }

                $transaction->update([
                    'payment_proof' => $path,
                    'status' => 'Pending'
                ]);
            }
        }

        return $transaction;
    }

    /**
     * Get booking history for a user.
     */
    public function getHistory(string $userId)
    {
        return Transaction::with(['listing', 'room'])
                          ->where('user_id', $userId)
                          ->latest()
                          ->get();
    }

    /**
     * Get unique inquiry threads for a tenant.
     */
    public function getInquiryThreads(string $userId)
    {
        return \App\Models\Inquiry::with(['listing', 'receiver'])
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get()
            ->groupBy(function($inquiry) use ($userId) {
                // Group by Listing + the "other" person in the conversation
                $otherId = $inquiry->sender_id === $userId ? $inquiry->receiver_id : $inquiry->sender_id;
                return $inquiry->listing_id . '_' . $otherId;
            })
            ->map(function($group) {
                return $group->first(); // Get the latest message for each thread
            });
    }

    /**
     * Get all messages in a specific thread.
     */
    public function getThreadMessages(string $userId, string $listingId)
    {
        $listing = Listing::findOrFail($listingId);
        $ownerId = $listing->owner_id;

        return \App\Models\Inquiry::where('listing_id', $listingId)
            ->where(function($q) use ($userId, $ownerId) {
                $q->where(function($sq) use ($userId, $ownerId) {
                    $sq->where('sender_id', $userId)->where('receiver_id', $ownerId);
                })->orWhere(function($sq) use ($userId, $ownerId) {
                    $sq->where('sender_id', $ownerId)->where('receiver_id', $userId);
                });
            })
            ->with(['sender', 'receiver'])
            ->oldest()
            ->get();
    }

    /**
     * Mark thread as read for the tenant.
     */
    public function markThreadAsRead(string $userId, string $listingId)
    {
        $listing = Listing::findOrFail($listingId);
        $ownerId = $listing->owner_id;

        return \App\Models\Inquiry::where('listing_id', $listingId)
            ->where('sender_id', $ownerId)
            ->where('receiver_id', $userId)
            ->where('status', 'Unread')
            ->update(['status' => 'Read']);
    }
}
