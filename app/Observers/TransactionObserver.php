<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Log;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     * Notify the listing owner and all super-admins about the new booking.
     */
    public function created(Transaction $transaction): void
    {
        // Set room status to 'Occupied' if payment is immediately successful
        if ($transaction->status === 'Paid' && $transaction->room_id) {
            $transaction->room->update(['status' => 'Occupied']);
        }

        // Notify the listing owner (pemilik-kos)
        $listing = $transaction->listing;
        if ($listing && $listing->user) {
            $listing->user->notify(new GeneralNotification(
                'Booking Baru Masuk',
                "Ada booking baru untuk properti \"{$listing->name}\" dari {$transaction->user->name}.",
                null
            ));
        }

        // Notify all super-admins
        $admins = User::role('super-admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new GeneralNotification(
                'Transaksi Baru',
                "Transaksi baru #{$transaction->id} dibuat untuk properti \"{$listing->name}\".",
                null
            ));
        }

        // Notify the seeker (pencari-kos) – confirmation
        $transaction->user->notify(new GeneralNotification(
            'Booking Berhasil Dibuat',
            "Booking Anda untuk \"{$listing->name}\" berhasil dibuat. Silakan lakukan pembayaran.",
            null
        ));
    }

    /**
     * Handle the Transaction "updated" event.
     * Notify relevant parties when status changes.
     */
    public function updated(Transaction $transaction): void
    {
        $listing = $transaction->listing;

        // When status changes to Paid/Active
        if ($transaction->isDirty('status') && in_array($transaction->status, ['Paid', 'Active'])) {

            // Update the Room status
            if ($transaction->room_id) {
                $transaction->room->update(['status' => 'Occupied']);
                Log::info("Room {$transaction->room->room_number} status updated to Occupied for transaction {$transaction->id}");
            }

            // Generate Digital Contract Code if not already present
            if (!$transaction->contract_code) {
                $transaction->updateQuietly([
                    'contract_code' => 'KOS/' . strtoupper(substr($listing->city, 0, 3)) . '/' . date('Ymd') . '/' . strtoupper(substr($transaction->id, 0, 8))
                ]);
            }

            // Notify pencari-kos: booking confirmed
            $transaction->user->notify(new GeneralNotification(
                'Booking Dikonfirmasi!',
                "Selamat! Booking Anda di \"{$listing->name}\" telah dikonfirmasi. Silakan check-in sesuai jadwal.",
                null
            ));

            // Notify super-admins
            $admins = User::role('super-admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new GeneralNotification(
                    'Pembayaran Dikonfirmasi',
                    "Transaksi #{$transaction->id} untuk \"{$listing->name}\" telah diverifikasi.",
                    null
                ));
            }
        }

        // When payment proof is uploaded (status stays Pending but payment_proof is set)
        if ($transaction->isDirty('payment_proof') && $transaction->payment_proof) {
            // Notify the owner to verify payment
            if ($listing && $listing->user) {
                $listing->user->notify(new GeneralNotification(
                    'Bukti Pembayaran Diterima',
                    "Pencari kos {$transaction->user->name} telah mengupload bukti pembayaran untuk \"{$listing->name}\". Mohon verifikasi.",
                    null
                ));
            }

            // Notify all super-admins
            $admins = User::role('super-admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new GeneralNotification(
                    'Bukti Pembayaran Baru',
                    "Bukti pembayaran untuk transaksi #{$transaction->id} telah diupload. Menunggu verifikasi.",
                    null
                ));
            }
        }

        // If cancelled or failed, revert room status and notify
        if ($transaction->isDirty('status') && in_array($transaction->status, ['Cancelled', 'Failed']) && $transaction->room_id) {
            $transaction->room->update(['status' => 'Available']);

            // Notify pencari-kos: booking rejected
            $transaction->user->notify(new GeneralNotification(
                'Booking Ditolak',
                "Maaf, booking Anda di \"{$listing->name}\" tidak dapat dikonfirmasi. Silakan coba kos lain.",
                null
            ));
        }
    }
}
