<?php

namespace Src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'type' => [
                'required',
                'in:income,expense',
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'transaction_date' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The transaction title is required.',
            'title.max' => 'The transaction title may not be greater than 255 characters.',

            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a valid number.',
            'amount.min' => 'The amount must be greater than or equal to zero.',

            'type.required' => 'The transaction type is required.',
            'type.in' => 'The transaction type must be either income or expense.',

            'category_id.required' => 'The category is required.',
            'category_id.integer' => 'The category ID must be an integer.',
            'category_id.exists' => 'The selected category does not exist.',

            'transaction_date.required' => 'The transaction date is required.',
            'transaction_date.date' => 'Please enter a valid transaction date.',

            'notes.string' => 'The notes must be a valid string.',
        ];
    }
}