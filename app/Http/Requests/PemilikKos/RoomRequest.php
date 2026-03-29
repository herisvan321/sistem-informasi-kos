<?php

namespace App\Http\Requests\PemilikKos;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_number' => 'required|string|max:50',
            'status' => 'required|string|in:Available,Full',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ];
    }
}
