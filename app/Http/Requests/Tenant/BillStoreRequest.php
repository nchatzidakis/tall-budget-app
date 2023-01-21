<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class BillStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                'exists:categories,id'
            ],
            'account_id' => [
                'nullable',
                'exists:accounts,id'
            ],
            'transactionAmount' => [
                'required',
                'numeric'
            ],
            'paid_at' => 'nullable',
            'expires_at' => 'nullable',
        ];
    }
}
