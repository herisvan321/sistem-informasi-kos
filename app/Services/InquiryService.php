<?php

namespace App\Services;

use App\Models\Inquiry;
use App\Models\User;

class InquiryService
{
    public function getAllGroupedForOwner(User $owner)
    {
        // Get all unique (client, listing) pairs the owner has interacted with
        $conversations = Inquiry::where('sender_id', $owner->id)
            ->orWhere('receiver_id', $owner->id)
            ->get()
            ->map(function ($inquiry) use ($owner) {
                $inquiry->partner_id = ($inquiry->sender_id == $owner->id) ? $inquiry->receiver_id : $inquiry->sender_id;
                return $inquiry;
            })
            ->groupBy(function ($inquiry) {
                return $inquiry->partner_id . '-' . $inquiry->listing_id;
            });

        return $conversations->map(function ($items) use ($owner) {
            $lastInquiry = $items->sortByDesc('created_at')->first();
            $partnerId = ($lastInquiry->sender_id == $owner->id) ? $lastInquiry->receiver_id : $lastInquiry->sender_id;
            
            // Re-fetch objects to ensure relations are loaded
            $partner = User::find($partnerId);
            $listing = \App\Models\Listing::find($lastInquiry->listing_id);

            return (object) [
                'sender' => $partner,
                'sender_id' => $partnerId,
                'listing' => $listing,
                'listing_id' => $lastInquiry->listing_id,
                'last_message' => $lastInquiry->message,
                'last_message_at' => $lastInquiry->created_at,
                'unread_count' => $items->where('receiver_id', $owner->id)->where('status', 'Unread')->count(),
                'sample_id' => $lastInquiry->id
            ];
        })->sortByDesc('last_message_at')->values();
    }

    public function getChatThread(User $owner, User $client, $listingId)
    {
        return Inquiry::where(function($q) use ($owner, $client, $listingId) {
                $q->where('sender_id', $owner->id)->where('receiver_id', $client->id);
            })
            ->orWhere(function($q) use ($owner, $client, $listingId) {
                $q->where('sender_id', $client->id)->where('receiver_id', $owner->id);
            })
            ->where('listing_id', $listingId)
            ->with(['sender', 'listing'])
            ->oldest()
            ->get();
    }

    public function markThreadAsRead(User $receiver, User $sender, $listingId)
    {
        return Inquiry::where('receiver_id', $receiver->id)
            ->where('sender_id', $sender->id)
            ->where('listing_id', $listingId)
            ->where('status', 'Unread')
            ->update(['status' => 'Read']);
    }

    public function respond(User $sender, User $receiver, $listingId, string $message)
    {
        return Inquiry::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'listing_id' => $listingId,
            'message' => $message,
            'status' => 'Unread'
        ]);
    }
}
