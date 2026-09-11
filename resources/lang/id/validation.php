<?php

return [

    'required' => ':attribute wajib diisi.',
    'string' => ':attribute harus berupa teks.',
    'integer' => ':attribute harus berupa angka bulat.',
    'numeric' => ':attribute harus berupa angka.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'date' => ':attribute harus berupa tanggal yang valid.',
    'boolean' => ':attribute harus berupa true atau false.',

    'min' => [
        'numeric' => ':attribute minimal harus :min.',
        'string' => ':attribute minimal harus :min karakter.',
        'array' => ':attribute minimal harus memiliki :min item.',
        'file' => ':attribute minimal harus berukuran :min kilobyte.',
    ],

    'max' => [
        'numeric' => ':attribute maksimal :max.',
        'string' => ':attribute maksimal :max karakter.',
        'array' => ':attribute maksimal :max item.',
        'file' => ':attribute maksimal berukuran :max kilobyte.',
    ],

    'between' => [
        'numeric' => ':attribute harus antara :min dan :max.',
        'string' => ':attribute harus antara :min dan :max karakter.',
        'array' => ':attribute harus memiliki antara :min dan :max item.',
        'file' => ':attribute harus berukuran antara :min dan :max kilobyte.',
    ],

    'in' => ':attribute yang dipilih tidak valid.',
    'not_in' => ':attribute yang dipilih tidak valid.',
    'unique' => ':attribute sudah digunakan.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'same' => ':attribute harus sama dengan :other.',
    'different' => ':attribute harus berbeda dari :other.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'regex' => 'Format :attribute tidak valid.',

    'attributes' => [
        'name' => 'nama',
        'email' => 'email',
        'password' => 'kata sandi',
        'password_confirmation' => 'konfirmasi kata sandi',
        'phone' => 'nomor telepon',
        'address' => 'alamat',

        'loan_number' => 'nomor pinjaman',
        'loan_date' => 'tanggal pinjaman',
        'principal' => 'pokok pinjaman',
        'interest_percent' => 'persentase jasa',
        'interest_amount' => 'jasa',
        'amount' => 'jumlah pinjaman',
        'remaining' => 'sisa pinjaman',
        'disbursement' => 'pencairan',

        'payment_date' => 'tanggal pembayaran',
        'payment_count' => 'angsuran ke',
        'meeting_id' => 'pertemuan',

        'meeting_date' => 'tanggal pertemuan',
        'place' => 'tempat',

        'saving_type' => 'jenis simpanan',
    ],

    'custom' => [

        'principal' => [
            'required' => 'Pokok pinjaman wajib diisi.',
            'numeric' => 'Pokok pinjaman harus berupa angka.',
            'min' => 'Pokok pinjaman minimal Rp :min.',
        ],

        'payment_count' => [
            'required' => 'Nomor angsuran wajib diisi.',
            'integer' => 'Nomor angsuran harus berupa angka bulat.',
            'between' => 'Nomor angsuran harus antara :min dan :max.',
        ],

        'loan_date' => [
            'required' => 'Tanggal pinjaman wajib diisi.',
            'date' => 'Tanggal pinjaman tidak valid.',
        ],

    ],

];
