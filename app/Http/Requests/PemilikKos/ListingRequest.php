<?php

namespace App\Http\Requests\PemilikKos;

use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // We'll handle this in the controller or policy
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'required|string',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'facilities' => 'nullable|array',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
