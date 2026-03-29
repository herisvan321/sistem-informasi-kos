<?php

namespace App\Http\Requests\PencariKos;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('pencari-kos');
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string|max:1000',
        ];
    }
}
