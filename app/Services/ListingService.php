<?php

namespace App\Services;

use App\Models\Listing;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ListingService
{
    public function getAllForOwner($ownerId)
    {
        return Listing::where('owner_id', $ownerId)->latest()->get();
    }

    public function create(array $data)
    {
        if (isset($data['main_photo'])) {
            $data['main_photo'] = $this->uploadPhoto($data['main_photo']);
        }

        return Listing::create($data);
    }

    public function update(Listing $listing, array $data)
    {
        if (isset($data['main_photo'])) {
            if ($listing->main_photo) {
                Storage::disk('public')->delete($listing->main_photo);
            }
            $data['main_photo'] = $this->uploadPhoto($data['main_photo']);
        }

        $listing->update($data);
        return $listing;
    }

    public function delete(Listing $listing)
    {
        if ($listing->main_photo) {
            Storage::disk('public')->delete($listing->main_photo);
        }
        return $listing->delete();
    }

    public function approve(Listing $listing)
    {
        return $listing->update([
            'status' => 'Approved',
            'rejection_reason' => null,
            'rejection_notes' => null,
        ]);
    }

    public function reject(Listing $listing, array $data)
    {
        return $listing->update([
            'status' => 'Rejected',
            'rejection_reason' => $data['rejection_reason'] ?? null,
            'rejection_notes' => $data['rejection_notes'] ?? null,
        ]);
    }

    public function requestPremium(Listing $listing)
    {
        // Now handled by redirecting to payment page
        return true;
    }

    public function submitPremiumProof(Listing $listing, $proofFile)
    {
        if ($listing->premium_payment_proof) {
            Storage::disk('public')->delete($listing->premium_payment_proof);
        }

        $filename = 'proof_' . Str::uuid() . '.' . $proofFile->getClientOriginalExtension();
        $path = $proofFile->storeAs('premium_proofs', $filename, 'public');

        return $listing->update([
            'premium_status' => 'pending',
            'premium_payment_proof' => $path
        ]);
    }

    public function togglePremium(Listing $listing)
    {
        $isPremium = !$listing->is_premium;
        return $listing->update([
            'is_premium' => $isPremium,
            'premium_status' => $isPremium ? 'approved' : 'none'
        ]);
    }

    public function approvePremiumListing(Listing $listing)
    {
        return $listing->update([
            'is_premium' => true,
            'premium_status' => 'approved',
        ]);
    }

    public function rejectPremiumListing(Listing $listing, array $data = [])
    {
        // When rejected, we might want to delete the proof or just set status to none
        if ($listing->premium_payment_proof) {
            Storage::disk('public')->delete($listing->premium_payment_proof);
        }

        return $listing->update([
            'is_premium' => false,
            'premium_status' => 'none',
            'premium_payment_proof' => null,
            'rejection_notes' => $data['rejection_notes'] ?? null,
        ]);
    }

    protected function uploadPhoto($photo)
    {
        $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
        return $photo->storeAs('listings', $filename, 'public');
    }
}
