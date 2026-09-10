<?php

return [
    'name' => 'Simpan Pinjam',

    'language' => 'Bahasa',

    'languages' => [
        'en' => 'Inggris',
        'id' => 'Indonesia',
    ],

    'auth' => [
        'layout' => [
            'logo' => 'Logo',
            'savings' => 'Simpanan',
            'loan' => 'Pinjaman',
            'payment' => 'Pembayaran',

            'secure_simple_management' => 'Pengelolaan keuangan yang aman dan sederhana',
            'welcome_back' => 'Selamat datang kembali!',
            'management_description' => 'Kelola anggota, simpanan, pinjaman, dan pembayaran dengan aman dalam satu tempat.',

            'manage_savings' => 'Kelola simpanan',
            'manage_loans' => 'Kelola pinjaman',
            'track_payments' => 'Pantau pembayaran',

            'secure' => 'Aman',
            'secure_account_access' => 'Akses akun yang aman',

            'all_rights_reserved' => 'Hak cipta dilindungi.',

            'welcome' => 'Selamat Datang',
            'manage_account' => 'Kelola akun Anda dengan mudah.',
        ],

        'register' => [
            'title' => 'Daftar',
            'heading' => 'Buat akun',
            'description' => 'Masukkan data Anda di bawah ini untuk membuat akun.',

            'name' => 'Nama',
            'name_placeholder' => 'Nama lengkap',

            'email' => 'Alamat email',

            'password' => 'Password',
            'password_placeholder' => 'Masukkan password Anda',

            'confirm_password' => 'Konfirmasi password',
            'confirm_password_placeholder' => 'Masukkan kembali password Anda',

            'create_account' => 'Buat akun',
            'creating_account' => 'Membuat akun...',

            'already_have_account' => 'Sudah memiliki akun?',
            'login' => 'Masuk',
        ],

        'login' => [
            'title' => 'Masuk',
            'heading' => 'Masuk ke akun Anda',
            'description' => 'Masukkan email dan password Anda di bawah ini untuk masuk.',

            'email' => 'Alamat email',

            'password' => 'Password',
            'password_placeholder' => 'Masukkan password Anda',

            'forgot_password' => 'Lupa password Anda?',

            'remember_me' => 'Ingat saya',

            'login' => 'Masuk',
            'logging_in' => 'Sedang masuk...',

            'dont_have_account' => 'Belum memiliki akun?',
            'sign_up' => 'Daftar',
        ],

        'forgot_password' => [
            'title' => 'Lupa Password',
            'heading' => 'Lupa password?',
            'description' => 'Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.',

            'email' => 'Alamat email',

            'send_reset_link' => 'Kirim tautan reset password',

            'remember_password' => 'Ingat password Anda?',
            'login' => 'Masuk',
        ],

        'confirm_password' => [
            'title' => 'Konfirmasi Password',
            'heading' => 'Konfirmasi identitas Anda',
            'description' => 'Ini adalah area aman aplikasi. Silakan konfirmasi identitas Anda sebelum melanjutkan.',

            'confirm_with_passkey' => 'Konfirmasi dengan passkey',
            'confirming' => 'Mengonfirmasi...',
            'or_confirm_with_password' => 'Atau konfirmasi dengan password',

            'password' => 'Password',
            'password_placeholder' => 'Masukkan password Anda',

            'confirm' => 'Konfirmasi password',
        ],

        'reset_password' => [
            'title' => 'Reset Password',
            'heading' => 'Buat password baru',
            'description' => 'Masukkan password baru Anda di bawah ini. Pastikan password kuat dan aman.',

            'email' => 'Alamat email',

            'new_password' => 'Password baru',
            'new_password_placeholder' => 'Masukkan password baru Anda',

            'confirm_password' => 'Konfirmasi password baru',
            'confirm_password_placeholder' => 'Masukkan kembali password baru Anda',

            'reset_password' => 'Reset password',
            'resetting' => 'Mereset password...',

            'security_hint' => 'Setelah password direset, Anda dapat menggunakannya untuk masuk ke akun Anda.',
        ],

        'two_factor' => [
            'title' => 'Autentikasi dua faktor',

            'authentication_code' => 'Kode autentikasi',
            'authentication_code_description' => 'Masukkan kode 6 digit dari aplikasi autentikator Anda untuk melanjutkan.',

            'recovery_code' => 'Kode pemulihan',
            'recovery_code_description' => 'Masukkan salah satu kode pemulihan darurat Anda untuk mengakses akun.',

            'otp_code' => 'Kode OTP',
            'recovery_code_placeholder' => 'Masukkan kode pemulihan Anda',

            'continue' => 'Lanjutkan',
            'or' => 'atau',

            'use_recovery_code' => 'Gunakan kode pemulihan',
            'use_authentication_code' => 'Gunakan kode autentikasi',

            'authentication_hint' => 'Gunakan kode yang dihasilkan oleh aplikasi autentikator Anda.',
            'recovery_hint' => 'Setiap kode pemulihan hanya dapat digunakan satu kali.',
        ],

        'email_verification' => [
            'title' => 'Verifikasi Email',
            'heading' => 'Verifikasi alamat email Anda',
            'description' => 'Silakan verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirim ke kotak masuk Anda.',

            'verification_link_sent' => 'Tautan verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat pendaftaran.',

            'resend_verification' => 'Kirim ulang email verifikasi',
            'logout' => 'Keluar',

            'help' => 'Periksa folder spam atau junk jika Anda tidak melihat email tersebut di kotak masuk.',
        ],
    ],

    'sidebar' => [
        'overview' => 'Ringkasan',
        'platform' => 'Platform',

        'sections' => [
            'meeting' => 'Pertemuan',
            'master_data' => 'Data Master',
            'transactions' => 'Transaksi',
            'reports' => 'Laporan',
        ],

        'meeting' => 'Pertemuan',
        'members' => 'Data Anggota',
        'customers' => 'Data Nasabah',
        'savings' => 'Simpanan',
        'loans' => 'Pinjaman',
        'payments' => 'Angsuran',
        'monthly_report' => 'Laporan Bulanan',
        'customer_report' => 'Laporan Nasabah',

        'admin' => 'Admin',

        'settings' => 'Pengaturan',
        'logout' => 'Keluar',
    ],

    'actions' => [
        'action' => 'Aksi',
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
        'pay' => 'Bayar',
    ],

    'overview' => [
        'title' => 'Ringkasan',
        'subtitle' => 'Ringkasan kondisi dan aktivitas Simpan Pinjam.',
        'date_format' => 'l, d F Y',

        'financial' => [
            'title' => 'Ringkasan Keuangan',

            'active_loans' => 'Pinjaman Aktif',
            'available_funds' => 'Dana tersedia',

            'balance' => 'Saldo',
            'receivable' => 'Piutang',
            'borrowed_money' => 'Uang yang dipinjam',

            'total' => 'Total Keseluruhan',
            'balance_plus_receivable' => 'Saldo + Piutang',
        ],

        'monthly' => [
            'loan' => 'Pinjaman Bulan Ini',
            'loan_description' => 'Aktivitas pencairan',

            'payment' => 'Angsuran Bulan Ini',
            'payment_description' => 'Total pembayaran',

            'transaction_count' => ':count Transaksi',

            'customers' => 'Nasabah',
            'membership_data' => 'Data keanggotaan',
            'total_members' => 'Total Anggota',
            'customer_count' => 'Nasabah',
            'active_loans' => 'Pinjaman Aktif',
        ],

        'loan_status' => [
            'title' => 'Kondisi Pinjaman',
            'description' => 'Distribusi status seluruh pinjaman.',
            'loan_count' => ':count Pinjaman',

            'running' => 'Berjalan',
            'finished' => 'Lunas',
            'overdue' => 'Telat',
        ],

        'payment_progress' => [
            'title' => 'Progress Angsuran',
            'description' => 'Distribusi pembayaran berdasarkan pertemuan ke-1 sampai ke-6.',
            'payment_number' => 'Ke-:number',
            'payment' => 'Pembayaran',
            'skip' => ':count Skip',
            'unpaid' => ':count Belum',
        ],

        'activity' => [
            'title' => 'Aktivitas Terbaru',
            'description' => 'Transaksi terakhir dalam aplikasi.',
            'sort_date' => 'Tanggal Transaksi',
            'sort_created' => 'Baru Dibuat',
            'empty' => 'Belum ada aktivitas.',
        ],

        'quick_action' => [
            'title' => 'Aksi Cepat',
            'description' => 'Akses fitur yang sering digunakan.',

            'loan' => 'Pinjaman',
            'payment' => 'Angsuran',
            'saving' => 'Simpanan',
            'monthly_report' => 'Laporan Bulanan',
            'customer_report' => 'Laporan Nasabah',
        ],
    ],

    'meeting' => [
        'title' => 'Pertemuan',
        'subtitle' => 'Kelola jadwal pertemuan SATYA MUDA GETAS',
        'singular' => 'Pertemuan',
        'search' => 'Cari pertemuan...',
        'place' => 'Tempat',
        'place_placeholder' => 'Contoh: Balai Desa',
        'date' => 'Tanggal',

        'form_create_description' => 'Buat jadwal pertemuan baru.',
        'form_edit_description' => 'Perbarui informasi pertemuan.',

        'information' => 'Informasi Pertemuan',
        'information_description' => 'Informasi dasar mengenai jadwal pertemuan.',

        'empty' => 'Belum ada pertemuan',
        'empty_description' => 'Data pertemuan akan muncul di sini setelah dibuat.',

        'tooltip_edit' => 'Edit :name',
        'tooltip_delete' => 'Hapus :name',
    ],

    'member' => [
        'title' => 'Anggota',
        'subtitle' => 'Kelola data anggota koperasi',
        'singular' => 'Anggota',
        'search' => 'Cari anggota...',
        'npk' => 'NPK',
        'name' => 'Nama',
        'full_name' => 'Nama Lengkap',
        'email' => 'Email',
        'email_placeholder' => 'email@katasama.or.id',
        'phone' => 'No. HP',
        'phone_placeholder' => '08xxxxxxxxxx',
        'age' => 'Umur',
        'year' => 'tahun',
        'age_value' => ':count tahun',
        'gender' => 'Jenis Kelamin',
        'date_birth' => 'Tanggal Lahir',
        'date_join' => 'Tanggal Bergabung',
        'status' => 'Status',

        'form_create_description' => 'Buat data anggota baru.',
        'form_edit_description' => 'Perbarui informasi anggota.',
        'form_select' => 'Pilih anggota',

        'information' => 'Informasi Anggota',
        'information_description' => 'Informasi dasar anggota yang terdaftar dalam sistem.',

        'information_status' => 'Status Keanggotaan',
        'information_status_description' => 'Atur status keanggotaan anggota dalam sistem.',

        'empty' => 'Belum ada anggota',
        'empty_description' => 'Data anggota akan muncul di sini setelah ditambahkan.',

        'tooltip_edit' => 'Edit :name',
        'tooltip_delete' => 'Hapus :name',
    ],

    'customer' => [
        'title' => 'Nasabah',
        'subtitle' => 'Daftar nasabah dengan riwayat pinjaman',
        'singular' => 'Nasabah',

        'search' => 'Cari nasabah...',

        'npk' => 'NPK',
        'name' => 'Nama',
        'full_name' => 'Nama Lengkap',
        'phone' => 'No. HP',
        'age' => 'Umur',
        'year' => 'tahun',
        'age_value' => ':count tahun',
        'gender' => 'Jenis Kelamin',
        'loan_count' => 'Pinjaman',
        'status' => 'Status',
        'date_birth' => 'Tanggal Lahir',

        'detail_title' => 'Detail Nasabah',
        'detail_subtitle' => 'Informasi detail nasabah dan riwayat pinjaman',

        'information' => 'Informasi Nasabah',
        'information_description' => 'Informasi dasar nasabah yang terdaftar dalam sistem.',

        'loan_history' => 'Riwayat Pinjaman',
        'loan_history_description' => 'Daftar pinjaman dan pembayaran nasabah.',

        'empty' => 'Belum ada nasabah',
        'empty_description' => 'Data nasabah akan muncul di sini setelah ditambahkan.',
    ],

    'loan_history' => [
        'payment_count' => 'Pembayaran',

        'loan_summary' => 'Ringkasan Pinjaman',
        'principal' => 'Pokok Pinjaman',
        'interest' => 'Bunga',
        'amount' => 'Total Pinjaman',
        'remaining' => 'Sisa Pinjaman',

        'payment_history' => 'Riwayat Pembayaran',
        'payment_history_description' => 'Daftar pembayaran pinjaman dari angsuran pertama hingga keenam.',

        'date' => 'Tanggal',
        'payment' => 'Pembayaran',
        'method' => 'Metode',
        'status' => 'Status',
        'note' => 'Catatan',

        'payment_note' => 'Catatan Pembayaran',
        'payment_note_count' => 'Pembayaran ke-:count',

        'empty' => 'Belum ada riwayat pinjaman',
        'empty_description' => 'Riwayat pinjaman nasabah akan muncul di sini.',
    ],

    'loan' => [
        'title' => 'Pinjaman',
        'subtitle' => 'Kelola data pinjaman dan status pembayaran nasabah',
        'singular' => 'Pinjaman',
        'search' => 'Cari pinjaman...',
        'loan_number' => 'No. Pinjaman',
        'name' => 'Nasabah',
        'date' => 'Tanggal',
        'date_loan' => 'Tanggal Pinjaman',
        'type' => 'Jenis',
        'type_loan' => 'Jenis Pinjaman',
        'principal' => 'Pokok',
        'interest' => 'Bunga',
        'interest_amount' => 'Nominal Bunga',
        'amount' => 'Total Pinjaman',
        'remaining' => 'Sisa',
        'status' => 'Status',

        'form_create_description' => 'Buat data pinjaman baru untuk nasabah.',
        'form_edit_description' => 'Perbarui informasi pinjaman nasabah.',
        'form_select' => 'Pilih nasabah',

        'information' => 'Informasi Pinjaman',
        'information_description' => 'Informasi dasar mengenai pinjaman nasabah.',
        'information_value' => 'Nilai Pinjaman',
        'information_value_description' => 'Rincian nilai pokok, bunga, dan total pinjaman.',

        'previous_loan' => 'Pinjaman Sebelumnya',
        'previous_loan_description' => 'Pinjaman berjalan yang akan digunakan sebagai acuan.',
        'previous_loan_disbursement' => 'Pencairan',

        'empty' => 'Belum ada pinjaman',
        'empty_description' => 'Data pinjaman akan muncul di sini setelah dibuat.',

        'tooltip_edit' => 'Edit :name',
        'tooltip_delete' => 'Hapus :name',
    ],

    'payment' => [
        'index' => [
            'title' => 'Rapat SATYA MUDA GETAS',
            'subtitle' => 'Kelola pembayaran pada setiap pertemuan',
            'singular' => 'Rapat',
            'search' => 'Cari pertemuan...',
            'place' => 'Tempat',
            'date' => 'Tanggal',
            'status' => 'Status Pembayaran',
            'empty' => 'Belum ada pertemuan',
            'empty_description' => 'Data pertemuan akan muncul di sini setelah dibuat.',
        ],

        'show' => [
            'title' => 'Pembayaran',
            'subtitle' => 'Kelola pembayaran angsuran nasabah pada pertemuan ini',
            'singular' => 'Pembayaran',

            'meet' => 'Pertemuan',
            'loan' => 'Pinjaman',
            'loan_number' => 'No. Pinjaman',
            'name' => 'Nasabah',
            'payment_number' => 'Pembayaran',
            'amount' => 'Total Pinjaman',
            'date' => 'Tanggal Pinjaman',
            'method' => 'Metode',
            'remaining' => 'Sisa',
            'status' => 'Status',

            'payment_amount' => 'Nominal Pembayaran',
            'note' => 'Catatan',
            'note_value' => 'Tambahkan catatan pembayaran...',

            'form_description' => 'Masukkan informasi pembayaran angsuran nasabah.',
            'form_select' => 'Pilih metode pembayaran',

            'form_create_title' => 'Tambah Pembayaran',
            'form_edit_title' => 'Edit Pembayaran',

            'empty' => 'Belum ada pinjaman',
            'empty_description' => 'Tidak ada pinjaman yang dapat ditampilkan pada pertemuan ini.',
            'unpaid' => 'Belum Dibayar',

            'tooltip_view' => 'Lihat :name',
            'tooltip_edit' => 'Edit :name',
            'tooltip_reset' => 'Reset :name',
        ],

        'detail' => [
            'title' => 'Detail Pembayaran',
            'subtitle' => 'Informasi lengkap pembayaran dan perkembangan pinjaman nasabah',

            'loan_number' => 'No. Pinjaman',
            'name' => 'Nasabah',
            'date' => 'Tanggal Pembayaran',
            'principal' => 'Pokok Pinjaman',

            'amount' => 'Total Pinjaman',
            'payment_number' => 'Pembayaran ke-:count',
            'paid' => 'Total Dibayar',
            'remaining' => 'Sisa Pinjaman',
            'note' => 'Catatan',
        ],

    ],

    'saving' => [
        'title' => 'Kas Simpanan',
        'subtitle' => 'Simpanan SATYA MUDA GETAS',
        'singular' => 'Simpanan',

        'transaction_date' => 'Tanggal Transaksi',
        'type' => 'Jenis',
        'debit' => 'Debit',
        'credit' => 'Kredit',
        'interest' => 'Jasa',
        'balance' => 'Saldo',
        'receivable' => 'Piutang',
        'amount' => 'Total',
        'amount_input' => 'Nominal',
        'description' => 'Keterangan',
        'description_placeholder' => 'Masukkan keterangan...',
        'automatic' => 'Otomatis',

        'modal_title' => 'Keterangan',
        'modal_subtitle' => 'Detail keterangan transaksi simpanan.',

        'empty' => 'Belum ada data simpanan',
        'empty_description' => 'Belum terdapat transaksi simpanan.',

        'form_create_description' => 'Masukkan transaksi kas baru.',
        'form_edit_description' => 'Perbarui data transaksi kas.',

        'information' => 'Informasi Transaksi',
        'information_description' => 'Tentukan tanggal, jenis, dan nominal transaksi.',
        'information_value_description' => 'Tambahkan catatan jika diperlukan.',

        'form_select' => 'Pilih Jenis Transaksi',

        'tooltip_edit' => 'Edit :name',
        'tooltip_delete' => 'Hapus :name',
    ],

    'monthly_report' => [
        'title' => 'Laporan Bulanan',
        'subtitle' => 'Ringkasan aktivitas, pinjaman, pembayaran, dan posisi keuangan.',
        'download_pdf' => 'Download PDF',

        'filter' => [
            'title' => 'Ringkasan Laporan Keuangan',
            'description' => 'Ringkasan posisi dan pergerakan keuangan selama periode laporan.',
            'month' => 'Bulan',
            'year' => 'Tahun',
        ],

        'opening' => [
            'balance' => 'Saldo Bulan Lalu',
            'receivable' => 'Piutang Bulan Lalu',
            'amount' => 'Total Bulan Lalu',
        ],

        'cash_flow' => [
            'title' => 'Pergerakan Keuangan',
            'description' => 'Perbandingan debit dan kredit selama periode laporan.',
            'debit' => 'Debit',
            'debit_description' => 'Total pemasukan',
            'credit' => 'Kredit',
            'credit_description' => 'Total pengeluaran',
            'transaction' => 'Transaksi',
        ],

        'position' => [
            'title' => 'Posisi Keuangan',
            'description' => 'Ringkasan kondisi keuangan pada akhir periode.',
            'balance' => 'Saldo Saat Ini',
            'receivable' => 'Piutang Saat Ini',
            'amount' => 'Total Saat Ini',
        ],

        'summary' => [
            'title' => 'Detail Ringkasan',
            'description' => 'Seluruh nilai utama dalam laporan keuangan.',
            'debit' => 'Debit',
            'credit' => 'Kredit',
            'balance' => 'Saldo',
            'receivable' => 'Piutang',
            'total_position' => 'Total Posisi',
        ],

        'loan' => [
            'title' => 'Pinjaman',
            'description' => 'Daftar pinjaman yang tercatat pada periode ini.',
            'customer' => 'Nasabah',
            'principal' => 'Pokok Pinjaman',
            'interest' => 'Jasa',
            'total' => 'Total',
            'status' => 'Status',
            'empty_title' => 'Belum ada pinjaman',
            'empty_description' => 'Tidak ada pinjaman pada periode ini.',
        ],

        'payment' => [
            'title' => 'Pembayaran',
            'description' => 'Riwayat pembayaran angsuran pada periode ini.',
            'customer' => 'Nasabah',
            'date' => 'Tanggal',
            'meeting' => 'Rapat',
            'installment' => 'Angsuran',
            'method' => 'Metode Bayar',
            'empty_title' => 'Belum ada pembayaran',
            'empty_description' => 'Tidak ada pembayaran pada periode ini.',
        ],
    ],

    'customer_report' => [
        'title' => 'Laporan Nasabah',
        'subtitle' => 'Ringkasan pinjaman, riwayat pembayaran, dan notifikasi nasabah.',

        'action' => [
            'pdf' => 'PDF',
            'send' => 'Kirim',
            'close' => 'Tutup',
            'detail' => 'Detail',
        ],

        'selector' => [
            'label' => 'Nasabah',
            'placeholder' => '-- Pilih Nasabah --',
        ],

        'information' => [
            'npk' => 'NPK',
            'phone' => 'HP',
            'loan_count' => 'Pinjaman',
            'notification_count' => 'Notifikasi',
        ],

        'tabs' => [
            'summary' => 'Ringkasan',
            'loans' => 'Riwayat Pinjaman',
            'notifications' => 'Notifikasi',
            'new' => 'baru',
        ],

        'summary' => [
            'total_loan' => 'Total Pinjaman',
            'total_paid' => 'Total Dibayar',
            'remaining' => 'Sisa Pinjaman',
            'outstanding' => 'Outstanding',
            'status' => 'Status',
            'running' => 'Masih Berjalan',
            'no_active_loan' => 'Tidak Ada Pinjaman Aktif',
            'transaction' => 'Transaksi',
            'information_title' => 'Informasi Nasabah',
            'information_description' => 'Gunakan tab di atas untuk melihat detail pinjaman dan notifikasi.',
        ],

        'loans' => [
            'title' => 'Riwayat Pinjaman',
            'description' => 'Detail pinjaman dan pembayaran nasabah.',
            'count' => 'Pinjaman',
        ],

        'notification' => [
            'title' => 'Notifikasi',
            'description' => 'Riwayat pemberitahuan dan bukti transaksi nasabah.',
            'search_placeholder' => 'Cari notifikasi...',
            'all_types' => 'Semua Jenis',
            'sent' => 'Terkirim',
            'not_sent' => 'Belum Dikirim',
            'read' => 'Dibaca',
            'unread' => 'Belum Dibaca',
            'new' => 'baru',
            'detail' => 'Detail',
            'send' => 'Kirim',
            'send_notification' => 'Kirim Notifikasi',

            'loan' => 'Pinjaman',
            'payment' => 'Pembayaran',
            'meeting' => 'Pertemuan',
            'created' => 'Dibuat',
            'message' => 'Isi Notifikasi',

            'sent_information' => 'Notifikasi telah dikirim',
            'not_sent_information' => 'Notifikasi belum dikirim.',

            'empty_title' => 'Belum ada notifikasi',
            'empty_description' => 'Notifikasi akan muncul setelah transaksi atau pengingat dibuat.',
        ],
    ],

    'profile' => [
        'settings' => 'Pengaturan Profil',
        'title' => 'Profil',
        'subtitle' => 'Kelola informasi profil dan alamat email Anda.',

        'information' => 'Informasi Profil',
        'information_description' => 'Perbarui nama dan alamat email akun Anda.',

        'name' => 'Nama',
        'name_placeholder' => 'Masukkan nama Anda',

        'email' => 'Email',
        'email_placeholder' => 'nama@email.com',

        'email_unverified' => 'Alamat email belum diverifikasi.',
        'email_unverified_description' => 'Silakan periksa inbox Anda atau kirim ulang email verifikasi.',
        'resend_verification' => 'Kirim ulang email verifikasi',

        'save_changes' => 'Simpan perubahan',
        'saving' => 'Menyimpan...',

        'delete_account' => 'Hapus Akun',
    ],

    'security' => [
        'settings' => 'Pengaturan Keamanan',
        'title' => 'Keamanan',
        'subtitle' => 'Kelola password dan keamanan akun Anda.',

        // Password
        'password' => 'Password',
        'password_description' => 'Gunakan password yang kuat dan unik untuk menjaga keamanan akun.',
        'current_password' => 'Password saat ini',
        'new_password' => 'Password baru',
        'confirm_password' => 'Konfirmasi password',

        // Two-factor authentication
        'two_factor' => 'Autentikasi dua faktor',
        'enabled' => 'Aktif',
        'disabled' => 'Nonaktif',
        'two_factor_description' => 'Tambahkan lapisan keamanan ekstra saat login.',
        'two_factor_active' => 'Autentikasi dua faktor aktif',
        'two_factor_active_description' => 'Kode verifikasi yang aman akan diperlukan saat Anda masuk. Anda dapat mengambil kode dari aplikasi yang mendukung TOTP.',
        'authenticator_app' => 'Aplikasi autentikator',
        'authenticator_app_description' => 'Akun Anda dilindungi dengan aplikasi autentikator.',
        'disable_2fa' => 'Nonaktifkan 2FA',
        'protect_account' => 'Lindungi akun Anda',
        'protect_account_description' => 'Saat diaktifkan, Anda akan diminta memasukkan kode verifikasi yang aman saat login. Kode dapat diambil dari aplikasi yang mendukung TOTP.',
        'enable_2fa' => 'Aktifkan 2FA',

        // Two-factor setup
        'otp_code' => 'Kode OTP',
        'back' => 'Kembali',
        'confirm' => 'Konfirmasi',
        'or_enter_manually' => 'atau, masukkan kode secara manual',

        // Passkeys
        'passkeys' => 'Passkey',
        'passkeys_description' => 'Gunakan passkey untuk login tanpa password.',
        'added' => 'Ditambahkan :time',
        'last_used' => 'Terakhir digunakan :time',
        'no_passkeys' => 'Belum ada passkey',
        'no_passkeys_description' => 'Tambahkan passkey untuk login tanpa password.',

        // Delete passkey
        'remove_passkey' => 'Hapus passkey',
        'remove_passkey_confirmation' => 'Apakah Anda yakin ingin menghapus passkey ":name"? Anda tidak dapat menggunakannya lagi untuk login.',

        // Actions
        'save_changes' => 'Simpan perubahan',
        'saving' => 'Menyimpan...',
        'cancel' => 'Batal',

        // Recovery codes
        'recovery_codes' => 'Kode pemulihan 2FA',
        'recovery_codes_description' => 'Kode pemulihan memungkinkan Anda mendapatkan kembali akses jika kehilangan perangkat 2FA. Simpan kode ini di pengelola password yang aman.',
        'keep_recovery_codes_safe' => 'Simpan kode pemulihan Anda di tempat yang aman.',
        'view_recovery_codes' => 'Lihat kode pemulihan',
        'hide_recovery_codes' => 'Sembunyikan kode pemulihan',
        'regenerate_codes' => 'Buat ulang kode',
        'regenerating' => 'Membuat ulang...',
        'recovery_codes_label' => 'Kode pemulihan',
        'recovery_codes_information' => 'Setiap kode pemulihan hanya dapat digunakan satu kali untuk mengakses akun Anda dan akan dihapus setelah digunakan. Jika Anda membutuhkan kode baru, klik Buat ulang kode di atas.',
    ],

    'delete_account' => [
        'title' => 'Hapus Akun',
        'description' => 'Hapus akun Anda beserta seluruh data dan sumber daya yang terkait.',

        'permanently_delete' => 'Hapus akun secara permanen',
        'permanently_delete_description' => 'Setelah akun Anda dihapus, seluruh data dan sumber daya yang terkait akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.',

        'confirm_title' => 'Apakah Anda yakin ingin menghapus akun?',
        'confirm_description' => 'Setelah akun Anda dihapus, seluruh data dan sumber daya yang terkait akan dihapus secara permanen. Masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.',

        'warning' => 'Tindakan ini bersifat permanen dan tidak dapat dibatalkan.',

        'password' => 'Password',

        'cancel' => 'Batal',
        'delete' => 'Hapus Akun',
        'deleting' => 'Menghapus...',
    ],

    'appearance' => [
        'settings' => 'Pengaturan Tampilan',
        'title' => 'Tampilan',
        'subtitle' => 'Sesuaikan tampilan aplikasi sesuai preferensi Anda.',

        'information' => 'Tampilan',
        'information_description' => 'Pilih tampilan yang paling nyaman untuk Anda.',

        'mode' => 'Mode tampilan',
        'mode_description' => 'Perubahan tampilan akan diterapkan secara otomatis.',

        'light' => 'Terang',
        'dark' => 'Gelap',
        'system' => 'Sistem',
    ],

    'mail' => [
        'email_changed' => [
            'subject' => 'Email Akun Diubah',
            'title' => 'Email Akun Diubah',
            'greeting' => 'Halo',
            'changed_description' => 'Alamat email yang terhubung dengan akun :app telah diubah.',
            'updated_description' => 'Alamat email akun :app telah berhasil diperbarui menjadi:',
            'old_email' => 'Email Lama',
            'new_email' => 'Email Baru',
            'not_you' => 'Bukan Anda?',
            'security_notice' => 'Pemberitahuan Keamanan',
            'not_you_description' => 'Jika Anda tidak melakukan perubahan email ini, segera hubungi administrator untuk mengamankan akun Anda.',
            'security_description' => 'Jika Anda yang melakukan perubahan ini, tidak ada tindakan lebih lanjut yang diperlukan.',
            'all_rights_reserved' => 'Hak cipta dilindungi.',
        ],

        'email_verification' => [
            'subject' => 'Verifikasi Email',
            'title' => 'Verifikasi Email Anda',
            'greeting' => 'Halo',
            'thank_you' => 'Terima kasih telah membuat akun di :app.',
            'verify_description' => 'Silakan verifikasi alamat email Anda untuk mengaktifkan akun.',
            'verify_button' => 'Verifikasi Email',
            'expires' => 'Link verifikasi ini berlaku selama :minutes menit.',
            'button_not_working' => 'Tombol tidak dapat diklik?',
            'copy_link' => 'Salin dan buka link berikut di browser:',
            'not_you' => 'Jika Anda tidak membuat akun ini, Anda dapat mengabaikan email ini.',
            'all_rights_reserved' => 'Hak cipta dilindungi.',
        ],

        'reset_password' => [
            'subject' => 'Reset Password',
            'title' => 'Reset Password',
            'greeting' => 'Halo',
            'request_description' => 'Kami menerima permintaan untuk mengatur ulang password akun :app Anda.',
            'reset_button' => 'Reset Password',
            'expires' => 'Link reset password ini berlaku selama :minutes menit.',
            'button_not_working' => 'Tombol tidak dapat diklik?',
            'copy_link' => 'Salin dan buka link berikut di browser:',
            'not_requested' => 'Jika Anda tidak meminta reset password, Anda dapat mengabaikan email ini.',
            'all_rights_reserved' => 'Hak cipta dilindungi.',
        ],

        'password_changed' => [
            'subject' => 'Password Berhasil Diubah',
            'title' => 'Password Berhasil Diubah',
            'greeting' => 'Halo',
            'changed_description' => 'Password akun :app Anda telah berhasil diubah.',
            'success_message' => 'Perubahan password berhasil dilakukan. Jika Anda yang melakukan perubahan ini, tidak ada tindakan lebih lanjut yang diperlukan.',
            'not_you' => 'Bukan Anda?',
            'security_warning' => 'Jika Anda tidak melakukan perubahan password ini, segera amankan akun Anda dan lakukan reset password.',
            'all_rights_reserved' => 'Hak cipta dilindungi.',
        ],
    ],
];
