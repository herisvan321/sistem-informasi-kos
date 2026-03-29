<?php

namespace App\Http\Requests\PencariKos;

use Illuminate\Foundation\Http\FormRequest;

class UploadPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('pencari-kos');
    }

    public function rules(): array
    {
        return [
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
