<?php

return [

    'required' => 'The :attribute field is required.',
    'string' => 'The :attribute field must be a string.',
    'integer' => 'The :attribute field must be an integer.',
    'numeric' => 'The :attribute field must be a number.',
    'email' => 'The :attribute field must be a valid email address.',
    'date' => 'The :attribute field must be a valid date.',
    'boolean' => 'The :attribute field must be true or false.',

    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
        'file' => 'The :attribute must be at least :min kilobytes.',
    ],

    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
    ],

    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
    ],

    'in' => 'The selected :attribute is invalid.',
    'not_in' => 'The selected :attribute is invalid.',
    'unique' => 'The :attribute has already been taken.',
    'exists' => 'The selected :attribute is invalid.',
    'same' => 'The :attribute must match :other.',
    'different' => 'The :attribute and :other must be different.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'regex' => 'The :attribute format is invalid.',

    'attributes' => [
        'name' => 'name',
        'email' => 'email',
        'password' => 'password',
        'password_confirmation' => 'password confirmation',
        'phone' => 'phone number',
        'address' => 'address',

        'loan_number' => 'loan number',
        'loan_date' => 'loan date',
        'principal' => 'loan principal',
        'interest_percent' => 'interest percentage',
        'interest_amount' => 'interest',
        'amount' => 'loan amount',
        'remaining' => 'remaining loan',

        'disbursement' => 'disbursement',

        'payment_date' => 'payment date',
        'payment_count' => 'installment number',
        'meeting_id' => 'meeting',

        'meeting_date' => 'meeting date',
        'place' => 'place',

        'saving_type' => 'saving type',
    ],

    'custom' => [

        'principal' => [
            'required' => 'Loan principal is required.',
            'numeric' => 'Loan principal must be a number.',
            'min' => 'Loan principal must be at least :min.',
        ],

        'payment_count' => [
            'required' => 'Installment number is required.',
            'integer' => 'Installment number must be an integer.',
            'between' => 'Installment number must be between :min and :max.',
        ],

        'loan_date' => [
            'required' => 'Loan date is required.',
            'date' => 'Loan date is invalid.',
        ],

    ],

];
