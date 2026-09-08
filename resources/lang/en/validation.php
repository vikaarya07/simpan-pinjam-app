<?php

return [
    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'unique' => 'The :attribute has already been taken.',
    'numeric' => 'The :attribute must be a number.',
    'integer' => 'The :attribute must be an integer.',
    'date' => 'The :attribute must be a valid date.',
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'string' => 'The :attribute may not be greater than :max characters.',
    ],

    'attributes' => [
        'name' => 'name',
        'npk' => 'member ID',
        'email' => 'email',
        'phone' => 'phone number',
        'principal' => 'principal amount',
        'amount' => 'amount',
        'payment_date' => 'payment date',
        'method' => 'payment method',
    ],
];
