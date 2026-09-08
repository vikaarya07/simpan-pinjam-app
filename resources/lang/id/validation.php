<?php

return [
    'required' => ':attribute wajib diisi.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'unique' => ':attribute sudah digunakan.',
    'numeric' => ':attribute harus berupa angka.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'date' => ':attribute harus berupa tanggal yang valid.',
    'max' => [
        'numeric' => ':attribute tidak boleh lebih dari :max.',
        'string' => ':attribute tidak boleh lebih dari :max karakter.',
    ],

    'attributes' => [
        'name' => 'nama',
        'npk' => 'NPK',
        'email' => 'email',
        'phone' => 'nomor telepon',
        'principal' => 'pokok pinjaman',
        'amount' => 'jumlah',
        'payment_date' => 'tanggal pembayaran',
        'method' => 'metode pembayaran',
    ],
];
