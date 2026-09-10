<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used
    | by the validator class. Some of these rules have multiple versions
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted' => ':attribute harus diterima.',
    'accepted_if' => ':attribute harus diterima jika :other adalah :value.',
    'active_url' => ':attribute bukan URL yang valid.',
    'after' => ':attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => ':attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => ':attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => ':attribute hanya boleh berisi huruf dan angka.',
    'array' => ':attribute harus berupa array.',
    'ascii' => ':attribute hanya boleh berisi karakter dan simbol alfanumerik ASCII.',
    'before' => ':attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => ':attribute harus memiliki :min sampai :max item.',
        'file' => ':attribute harus berukuran antara :min sampai :max kilobyte.',
        'numeric' => ':attribute harus bernilai antara :min sampai :max.',
        'string' => ':attribute harus memiliki panjang antara :min sampai :max karakter.',
    ],
    'boolean' => 'Kolom :attribute harus bernilai benar atau salah.',
    'can' => ':attribute berisi nilai yang tidak diizinkan.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'contains' => ':attribute tidak mengandung nilai yang diperlukan.',
    'current_password' => 'Kata sandi salah.',
    'date' => ':attribute bukan tanggal yang valid.',
    'date_equals' => ':attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => ':attribute tidak sesuai dengan format :format.',
    'decimal' => ':attribute harus memiliki :decimal angka desimal.',
    'declined' => ':attribute harus ditolak.',
    'declined_if' => ':attribute harus ditolak jika :other adalah :value.',
    'different' => ':attribute dan :other harus berbeda.',
    'digits' => ':attribute harus terdiri dari :digits digit.',
    'digits_between' => ':attribute harus terdiri dari :min sampai :max digit.',
    'dimensions' => 'Ukuran gambar :attribute tidak valid.',
    'distinct' => 'Kolom :attribute memiliki nilai yang duplikat.',
    'doesnt_end_with' => ':attribute tidak boleh diakhiri dengan salah satu dari berikut: :values.',
    'doesnt_start_with' => ':attribute tidak boleh diawali dengan salah satu dari berikut: :values.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'ends_with' => ':attribute harus diakhiri dengan salah satu dari berikut: :values.',
    'enum' => ':attribute yang dipilih tidak valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'extensions' => ':attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file' => ':attribute harus berupa file.',
    'filled' => ':attribute wajib diisi.',
    'gt' => [
        'array' => ':attribute harus memiliki lebih dari :value item.',
        'file' => ':attribute harus lebih besar dari :value kilobyte.',
        'numeric' => ':attribute harus lebih besar dari :value.',
        'string' => ':attribute harus lebih dari :value karakter.',
    ],
    'gte' => [
        'array' => ':attribute harus memiliki :value item atau lebih.',
        'file' => ':attribute harus lebih besar dari atau sama dengan :value kilobyte.',
        'numeric' => ':attribute harus lebih besar dari atau sama dengan :value.',
        'string' => ':attribute harus memiliki setidaknya :value karakter.',
    ],
    'hex_color' => ':attribute harus berupa warna heksadesimal yang valid.',
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'in_array' => ':attribute harus ada di dalam :other.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'ip' => ':attribute harus berupa alamat IP yang valid.',
    'ipv4' => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => ':attribute harus berupa alamat IPv6 yang valid.',
    'json' => ':attribute harus berupa JSON yang valid.',
    'lowercase' => ':attribute harus menggunakan huruf kecil.',
    'lt' => [
        'array' => ':attribute harus memiliki kurang dari :value item.',
        'file' => ':attribute harus lebih kecil dari :value kilobyte.',
        'numeric' => ':attribute harus lebih kecil dari :value.',
        'string' => ':attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => ':attribute tidak boleh memiliki lebih dari :value item.',
        'file' => ':attribute harus lebih kecil dari atau sama dengan :value kilobyte.',
        'numeric' => ':attribute harus lebih kecil dari atau sama dengan :value.',
        'string' => ':attribute tidak boleh lebih dari :value karakter.',
    ],
    'mac_address' => ':attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => ':attribute tidak boleh memiliki lebih dari :max item.',
        'file' => ':attribute tidak boleh lebih besar dari :max kilobyte.',
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'string' => ':attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits' => ':attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes' => ':attribute harus berupa file dengan tipe: :values.',
    'mimetypes' => ':attribute harus berupa file dengan tipe: :values.',
    'min' => [
        'array' => ':attribute minimal harus memiliki :min item.',
        'file' => ':attribute minimal harus berukuran :min kilobyte.',
        'numeric' => ':attribute minimal harus bernilai :min.',
        'string' => ':attribute minimal harus memiliki :min karakter.',
    ],
    'min_digits' => ':attribute minimal harus memiliki :min digit.',
    'missing' => ':attribute harus tidak ada.',
    'missing_if' => ':attribute harus tidak ada jika :other adalah :value.',
    'missing_unless' => ':attribute harus tidak ada kecuali :other adalah :value.',
    'missing_with' => ':attribute harus tidak ada jika :values ada.',
    'missing_with_all' => ':attribute harus tidak ada jika semua :values ada.',
    'multiple_of' => ':attribute harus merupakan kelipatan dari :value.',
    'not_in' => ':attribute yang dipilih tidak valid.',
    'not_regex' => 'Format :attribute tidak valid.',
    'numeric' => ':attribute harus berupa angka.',
    'password' => 'Kata sandi salah.',
    'present' => 'Kolom :attribute harus ada.',
    'present_if' => 'Kolom :attribute harus ada jika :other adalah :value.',
    'present_unless' => 'Kolom :attribute harus ada kecuali :other adalah :value.',
    'present_with' => 'Kolom :attribute harus ada jika :values ada.',
    'present_with_all' => 'Kolom :attribute harus ada jika semua :values ada.',
    'prohibited' => ':attribute dilarang.',
    'prohibited_if' => ':attribute dilarang jika :other adalah :value.',
    'prohibited_unless' => ':attribute dilarang kecuali :other memiliki nilai :values.',
    'prohibited_with' => ':attribute dilarang jika :values ada.',
    'prohibited_with_all' => ':attribute dilarang jika semua :values ada.',
    'regex' => 'Format :attribute tidak valid.',
    'required' => ':attribute wajib diisi.',
    'required_array_keys' => ':attribute harus berisi entri untuk: :values.',
    'required_if' => ':attribute wajib diisi jika :other adalah :value.',
    'required_if_accepted' => ':attribute wajib diisi jika :other diterima.',
    'required_if_declined' => ':attribute wajib diisi jika :other ditolak.',
    'required_unless' => ':attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with' => ':attribute wajib diisi jika :values ada.',
    'required_with_all' => ':attribute wajib diisi jika semua :values ada.',
    'required_without' => ':attribute wajib diisi jika :values tidak ada.',
    'required_without_all' => ':attribute wajib diisi jika semua :values tidak ada.',
    'same' => ':attribute dan :other harus cocok.',
    'size' => [
        'array' => ':attribute harus memiliki :size item.',
        'file' => ':attribute harus berukuran :size kilobyte.',
        'numeric' => ':attribute harus bernilai :size.',
        'string' => ':attribute harus memiliki :size karakter.',
    ],
    'starts_with' => ':attribute harus diawali dengan salah satu dari berikut: :values.',
    'string' => ':attribute harus berupa teks.',
    'timezone' => ':attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute sudah digunakan.',
    'uploaded' => ':attribute gagal diunggah.',
    'uppercase' => ':attribute harus menggunakan huruf kapital.',
    'url' => ':attribute harus berupa URL yang valid.',
    'ulid' => ':attribute harus berupa ULID yang valid.',
    'uuid' => ':attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'custom' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | These language lines are used to swap our attribute placeholder with
    | something more reader friendly such as "E-Mail Address" instead of
    | "email". This simply makes our message a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'nama',
        'email' => 'email',
        'password' => 'kata sandi',
        'password_confirmation' => 'konfirmasi kata sandi',

        'npk' => 'NPK',
        'member_id' => 'nasabah',
        'customer_id' => 'nasabah',

        'phone' => 'nomor telepon',
        'address' => 'alamat',
        'gender' => 'jenis kelamin',
        'date_join' => 'tanggal bergabung',
        'status' => 'status',

        'loan_number' => 'nomor pinjaman',
        'loan_date' => 'tanggal pinjaman',
        'loan_type' => 'jenis pinjaman',
        'type' => 'jenis',
        'principal' => 'pokok pinjaman',
        'interest_percent' => 'persentase bunga',
        'interest_amount' => 'jumlah bunga',
        'amount' => 'jumlah',
        'remaining' => 'sisa pinjaman',
        'disbursement' => 'pencairan',
        'previous_loan_id' => 'pinjaman sebelumnya',

        'meeting_id' => 'pertemuan',
        'meeting_date' => 'tanggal pertemuan',
        'place' => 'tempat',

        'payment_date' => 'tanggal pembayaran',
        'payment_count' => 'angsuran ke',
        'method' => 'metode pembayaran',
        'note' => 'catatan',

        'saving_date' => 'tanggal simpanan',
        'transaction_date' => 'tanggal transaksi',
        'saving_type' => 'jenis simpanan',
        'balance' => 'saldo',
        'receivable' => 'piutang',
        'description' => 'keterangan',

        'month' => 'bulan',
        'year' => 'tahun',
        'search' => 'pencarian',
    ],

];