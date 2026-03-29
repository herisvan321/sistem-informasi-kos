<?php

namespace App\Http\Requests\PencariKos;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('pencari-kos');
    }

    public function rules(): array
    {
        return [
            'listing_id' => 'required|uuid|exists:listings,id',
            'room_id' => 'required|uuid|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'duration_months' => 'required|integer|min:1|max:12',
            'payment_method' => 'required|string|in:Transfer Bank,E-Wallet,Tunai',
            'notes' => 'nullable|string|max:500',
        ];
    }
}
