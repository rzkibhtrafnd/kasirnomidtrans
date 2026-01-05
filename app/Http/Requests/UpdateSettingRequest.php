<?php

namespace App\Http\Requests;

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
            'company_name'   => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:500',
            'wifi'           => 'nullable|string|max:255',
            'wifi_password'  => 'nullable|string|max:255',
            'img_logo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'img_qris'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
