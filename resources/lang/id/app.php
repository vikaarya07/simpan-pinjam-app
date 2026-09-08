<?php

return [
    'name' => 'Simpan Pinjam',

    'language' => 'Bahasa',

    'languages' => [
        'en' => 'Inggris',
        'id' => 'Indonesia',
    ],

    'nav' => [
        'overview' => 'Overview',
        'members' => 'Anggota',
        'customers' => 'Nasabah',
        'loans' => 'Pinjaman',
        'payments' => 'Pembayaran',
        'meetings' => 'Pertemuan',
        'savings' => 'Simpanan',
        'reports' => 'Laporan',
        'settings' => 'Pengaturan',
    ],

    'actions' => [
        'add' => 'Tambah',
        'create' => 'Buat',
        'edit' => 'Edit',
        'update' => 'Perbarui',
        'delete' => 'Hapus',
        'save' => 'Simpan',
        'cancel' => 'Batal',
        'close' => 'Tutup',
        'search' => 'Cari',
        'filter' => 'Filter',
        'reset' => 'Reset',
        'back' => 'Kembali',
        'view' => 'Lihat',
        'download' => 'Unduh',
        'submit' => 'Kirim',
    ],

    'action' => 'Aksi',

    'meeting' => [
        'title' => 'Data Rapat',
        'subtitle' => 'Daftar seluruh rapat SATYA MUDA GETAS',
        'singular' => 'Rapat',

        'search' => 'Cari tempat...',

        'place' => 'Tempat',
        'date' => 'Tanggal',

        'form_create_description' => 'Lengkapi data untuk membuat pinjaman baru.',
        'form_edit_description' => 'Perbarui informasi pinjaman anggota.',

        'information' => 'Informasi Rapat',
        'information_description' => 'Tentukan tempat dan waktu pelaksanaan rapat.',

        'empty' => 'Belum ada data rapat',
        'empty_description' => 'Belum terdapat jadwal rapat yang terdaftar.',
    ],

    'member' => [
        'title' => 'Data Anggota',
        'subtitle' => 'Daftar seluruh anggota SATYA MUDA GETAS',
        'singular' => 'Anggota',

        'search' => 'Cari NPK, nama, atau nomor telepon...',

        'npk' => 'NPK',
        'name' => 'Nama',
        'full_name' => 'Nama Lengkap',
        'email' => 'Email',
        'phone' => 'No. Telepon',
        'age' => 'Usia',
        'gender' => 'Jenis Kelamin',
        'date_birth' => 'Tanggal Lahir',
        'date_join' => 'Tanggal Bergabung',
        'status' => 'Status',

        'form_create_description' => 'Lengkapi data anggota untuk mendaftarkan anggota baru.',
        'form_edit_description' => 'Perbarui informasi data anggota.',

        'form_select' => 'Pilih Jenis Kelamin',

        'information' => 'Data Pribadi',
        'information_description' => 'Informasi dasar anggota.',
        'information_status' => 'Keanggotaan',
        'information_status_description' => 'Status keanggotaan anggota.',

        'empty' => 'Belum ada data anggota',
        'empty_description' => 'Belum terdapat anggota yang terdaftar.',
    ],

    'customer' => [
        'title' => 'Data Nasabah',
        'subtitle' => 'Daftar seluruh nasabah SATYA MUDA GETAS',
        'detail_title' => 'Detail Nasabah',
        'detail_subtitle' => 'Informasi nasabah dan riwayat pinjaman.',
        'information' => 'Informasi Nasabah',
        'information_description' => 'Data utama nasabah.',

        'search' => 'Cari NPK, nama, atau nomor telepon...',

        'npk' => 'NPK',
        'name' => 'Nama',
        'loan_count' => 'Jumlah Pinjaman',
        'phone' => 'No. Telepon',
        'gender' => 'Jenis Kelamin',
        'age' => 'Usia',
        'status' => 'Status',
        'year' => 'Tahun',

        'loan_history' => 'Riwayat Pinjaman',
        'loan_history_description' => 'Daftar pinjaman dan riwayat pembayaran nasabah.',

        'empty' => 'Belum ada nasabah',
        'empty_description' => 'Belum terdapat anggota yang memiliki riwayat pinjaman.',
    ],

    'loan_history' => [
        'payment_count' => 'Pembayaran',

        'laon_summary' => 'Ringkasan Pinjaman',
        'principal' => 'Pokok Pinjaman',
        'interest' => 'Bunga',
        'amount' => 'Total Pinjaman',
        'remaining' => 'Sisa Pinjaman',

        'payment_history' => 'Riwayat Pembayaran',
        'payment_history_description' => 'Maksimal 6 kali pembayaran.',

        'to' => 'Ke',
        'date' => 'Tanggal',
        'payment' => 'Angsuran',
        'method' => 'Metode',
        'status' => 'Status',
        'note' => 'Catatan',

        'payment_note' => 'Catatan Pembayaran',
        'payment_note_count' => 'Pembayaran ke-',

        'empty' => 'Belum ada riwayat pinjaman',
        'empty_description' => 'Nasabah ini belum memiliki riwayat pinjaman.',
    ],

    'loan' => [
        'title' => 'Data Pinjaman',
        'subtitle' => 'Daftar pinjaman SATYA MUDA GETAS',
        'singular' => 'Pinjaman',

        'search' => 'Cari nomor pinjaman, nasabah atau waktu...',

        'loan_number' => 'Nomor Pinjaman',
        'name' => 'Nasabah',
        'date' => 'Tanggal',
        'type' => 'Jenis',
        'principal' => 'Pokok Pinjaman',
        'interest' => 'Jasa',
        'interest_amount' => 'Jumlah Jasa',
        'amount' => 'Total Pinjaman',
        'remaining' => 'Sisa Hutang',
        'status' => 'Status',

        'form_create_description' => 'Lengkapi data untuk membuat pinjaman baru.',
        'form_edit_description' => 'Perbarui informasi pinjaman anggota.',

        'information' => 'Informasi Pinjaman',
        'information_description' => 'Tentukan anggota, jenis, tanggal, dan pokok pinjaman.',
        'information_value' => 'Nilai Pinjaman',
        'information_value_description' => 'Masukkan pokok pinjaman. Jasa dan total dihitung otomatis.',

        'form_select' => 'Pilih Anggota',

        'previous_loan' => 'Pinjaman Sebelumnya',
        'previous_loan_description' => 'Ringkasan pinjaman anggota sebelumnya.',
        'previous_loan_disbursement' => 'Dana Dicairkan',

        'empty' => 'Belum ada data pinjaman',
        'empty_description' => 'Belum terdapat pinjaman yang terdaftar.',
    ],


    'payment' => [
        'title' => 'Rapat SATYA MUDA GETAS',
        'subtitle' => 'Daftar rapat dan status angsuran nasabah',
        'singular' => 'Rapat',

        'search' => 'Cari tempat...',

        'place' => 'Tempat',
        'date' => 'Tanggal',

        'form_create_description' => 'Lengkapi data untuk membuat pinjaman baru.',
        'form_edit_description' => 'Perbarui informasi pinjaman anggota.',

        'information' => 'Informasi Rapat',
        'information_description' => 'Tentukan tempat dan waktu pelaksanaan rapat.',

        'empty' => 'Belum ada data rapat',
        'empty_description' => 'Belum terdapat jadwal rapat yang terdaftar.',
    ],

    'saving' => [
        'title' => 'Kas Simpanan',
        'singular' => 'Simpanan',
        'transaction_date' => 'Tanggal Transaksi',
        'type' => 'Jenis',
        'debit' => 'Debit',
        'credit' => 'Kredit',
        'balance' => 'Saldo',
        'receivable' => 'Piutang',
        'amount' => 'Jumlah',
        'description' => 'Keterangan',
    ],
];
