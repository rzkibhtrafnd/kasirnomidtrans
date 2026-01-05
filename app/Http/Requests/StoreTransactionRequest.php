<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cart'           => ['required', 'json'],
            'payment_method' => ['required', 'in:cash,qris'],
        ];
    }
}
