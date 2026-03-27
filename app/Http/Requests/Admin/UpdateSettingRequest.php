<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'app_name' => 'required|string|max:255',
            'app_name_suffix' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'premium_price' => 'required|numeric|min:0',
            'maintenance_mode' => 'required|in:0,1',
        ];
    }
}
