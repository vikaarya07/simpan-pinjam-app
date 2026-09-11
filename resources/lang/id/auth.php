<?php

return [

    // Laravel Authentication Messages
    'failed' => 'Email atau password yang diberikan tidak sesuai dengan data kami.',
    'password' => 'Password yang diberikan salah.',
    'throttle' => 'Terlalu banyak percobaan masuk. Silakan coba lagi dalam :seconds detik.',

    // General Authentication
    'authentication_failed' => 'Autentikasi gagal. Silakan coba lagi.',
    'unauthorized' => 'Anda tidak memiliki izin untuk melakukan tindakan ini.',
    'session_expired' => 'Sesi Anda telah berakhir. Silakan masuk kembali.',
    'account_not_found' => 'Akun tidak ditemukan.',
    'account_disabled' => 'Akun Anda telah dinonaktifkan.',
    'account_locked' => 'Akun Anda terkunci. Silakan coba lagi nanti.',

    // Layout
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

    // Login
    'login' => [
        'title' => 'Masuk',
        'heading' => 'Masuk ke akun Anda',
        'description' => 'Masukkan email dan password Anda di bawah ini untuk masuk.',

        'email' => 'Alamat email',
        'email_placeholder' => 'Masukkan alamat email Anda',

        'password' => 'Password',
        'password_placeholder' => 'Masukkan password Anda',

        'forgot_password' => 'Lupa password Anda?',
        'remember_me' => 'Ingat saya',

        'login' => 'Masuk',
        'logging_in' => 'Sedang masuk...',

        'dont_have_account' => 'Belum memiliki akun?',
        'sign_up' => 'Daftar',

        'failed' => 'Email atau password yang diberikan tidak sesuai dengan data kami.',
        'throttled' => 'Terlalu banyak percobaan masuk. Silakan coba lagi dalam :seconds detik.',
        'success' => 'Berhasil masuk.',
    ],

    // Register
    'register' => [
        'title' => 'Daftar',
        'heading' => 'Buat akun',
        'description' => 'Masukkan data Anda di bawah ini untuk membuat akun.',

        'name' => 'Nama',
        'name_placeholder' => 'Nama lengkap',

        'email' => 'Alamat email',
        'email_placeholder' => 'Masukkan alamat email Anda',

        'password' => 'Password',
        'password_placeholder' => 'Masukkan password Anda',

        'confirm_password' => 'Konfirmasi password',
        'confirm_password_placeholder' => 'Masukkan kembali password Anda',

        'create_account' => 'Buat akun',
        'creating_account' => 'Membuat akun...',

        'already_have_account' => 'Sudah memiliki akun?',
        'login' => 'Masuk',

        'success' => 'Akun berhasil dibuat.',
        'failed' => 'Pendaftaran akun gagal. Silakan coba lagi.',
    ],

    // Logout
    'logout' => [
        'button' => 'Keluar',

        'confirm_title' => 'Keluar dari akun?',
        'confirm_text' => 'Anda akan keluar dari akun ini.',
        'confirm_button' => 'Ya, keluar',
        'cancel_button' => 'Batal',

        'success' => 'Anda berhasil keluar.',
    ],

    // Forgot Password
    'forgot_password' => [
        'title' => 'Lupa Password',
        'heading' => 'Lupa password?',
        'description' => 'Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.',

        'email' => 'Alamat email',
        'email_placeholder' => 'Masukkan alamat email Anda',

        'send_reset_link' => 'Kirim tautan reset password',
        'sending' => 'Mengirim tautan...',

        'remember_password' => 'Ingat password Anda?',
        'login' => 'Masuk',

        'sent' => 'Tautan reset password telah dikirim ke alamat email Anda.',
        'failed' => 'Kami tidak dapat mengirim tautan reset password. Silakan coba lagi.',
    ],

    // Reset Password
    'reset_password' => [
        'title' => 'Reset Password',
        'heading' => 'Buat password baru',
        'description' => 'Masukkan password baru Anda di bawah ini. Pastikan password kuat dan aman.',

        'email' => 'Alamat email',
        'email_placeholder' => 'Masukkan alamat email Anda',

        'new_password' => 'Password baru',
        'new_password_placeholder' => 'Masukkan password baru Anda',

        'confirm_password' => 'Konfirmasi password baru',
        'confirm_password_placeholder' => 'Masukkan kembali password baru Anda',

        'reset_password' => 'Reset password',
        'resetting' => 'Mereset password...',

        'security_hint' => 'Setelah password direset, Anda dapat menggunakannya untuk masuk ke akun Anda.',

        'success' => 'Password berhasil direset.',
        'failed' => 'Tautan reset password tidak valid atau telah kedaluwarsa.',
        'invalid_token' => 'Token reset password tidak valid.',
        'expired' => 'Tautan reset password telah kedaluwarsa.',
    ],
    
    // Confirm Password
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

        'success' => 'Password berhasil dikonfirmasi.',
        'failed' => 'Password yang diberikan salah.',
    ],

    // Email Verification
    'email_verification' => [
        'title' => 'Verifikasi Email',
        'heading' => 'Verifikasi alamat email Anda',

        'description' => 'Silakan verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirim ke kotak masuk Anda.',

        'verification_link_sent' => 'Tautan verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat pendaftaran.',

        'resend_verification' => 'Kirim ulang email verifikasi',
        'resending' => 'Mengirim ulang...',

        'logout' => 'Keluar',

        'verified' => 'Alamat email Anda berhasil diverifikasi.',
        'already_verified' => 'Alamat email Anda sudah diverifikasi.',

        'help' => 'Periksa folder spam atau junk jika Anda tidak melihat email tersebut di kotak masuk.',
    ],

    // Two-Factor Authentication
    'two_factor' => [
        'title' => 'Autentikasi Dua Faktor',

        'authentication_code' => 'Kode autentikasi',
        'authentication_code_description' => 'Masukkan kode 6 digit dari aplikasi autentikator Anda untuk melanjutkan.',

        'recovery_code' => 'Kode pemulihan',
        'recovery_code_description' => 'Masukkan salah satu kode pemulihan darurat Anda untuk mengakses akun.',

        'otp_code' => 'Kode OTP',
        'otp_code_placeholder' => 'Masukkan kode OTP Anda',

        'recovery_code_placeholder' => 'Masukkan kode pemulihan Anda',

        'continue' => 'Lanjutkan',
        'verifying' => 'Memverifikasi...',

        'or' => 'atau',

        'use_recovery_code' => 'Gunakan kode pemulihan',
        'use_authentication_code' => 'Gunakan kode autentikasi',

        'authentication_hint' => 'Gunakan kode yang dihasilkan oleh aplikasi autentikator Anda.',
        'recovery_hint' => 'Setiap kode pemulihan hanya dapat digunakan satu kali.',

        'invalid_code' => 'Kode autentikasi yang diberikan tidak valid.',
        'invalid_recovery_code' => 'Kode pemulihan yang diberikan tidak valid.',
        'failed' => 'Verifikasi dua faktor gagal. Silakan coba lagi.',
        'success' => 'Autentikasi dua faktor berhasil.',
    ],

    // Passkey
    'passkey' => [
        'title' => 'Passkey',
        'heading' => 'Masuk dengan Passkey',
        'description' => 'Gunakan Passkey perangkat Anda untuk masuk dengan aman.',

        'login' => 'Masuk dengan Passkey',
        'confirm' => 'Konfirmasi dengan Passkey',

        'authenticating' => 'Memverifikasi Passkey...',
        'success' => 'Berhasil masuk menggunakan Passkey.',

        'failed' => 'Passkey tidak dapat diverifikasi.',
        'unsupported' => 'Perangkat atau browser Anda tidak mendukung Passkey.',
        'cancelled' => 'Autentikasi Passkey dibatalkan.',
        'not_found' => 'Passkey tidak ditemukan.',
        'not_allowed' => 'Penggunaan Passkey tidak diizinkan.',
    ],

    // Password Change
    'password_change' => [
        'title' => 'Ubah Password',

        'current_password' => 'Password saat ini',
        'new_password' => 'Password baru',
        'confirm_password' => 'Konfirmasi password baru',

        'button' => 'Ubah password',
        'changing' => 'Mengubah password...',

        'success' => 'Password berhasil diubah.',
        'failed' => 'Password gagal diubah.',
        'current_password_incorrect' => 'Password saat ini salah.',
    ],

    // Email Change
    'email_change' => [
        'title' => 'Ubah Alamat Email',

        'current_email' => 'Email saat ini',
        'new_email' => 'Email baru',
        'password' => 'Password',

        'button' => 'Ubah email',
        'changing' => 'Mengubah email...',

        'success' => 'Alamat email berhasil diubah.',
        'failed' => 'Alamat email gagal diubah.',
        'verification_required' => 'Silakan verifikasi alamat email baru Anda.',
    ],

    // Account Recovery
    'recovery' => [
        'title' => 'Pemulihan Akun',
        'description' => 'Gunakan metode pemulihan yang tersedia untuk mendapatkan kembali akses ke akun Anda.',

        'code' => 'Kode pemulihan',
        'code_placeholder' => 'Masukkan kode pemulihan',

        'verify' => 'Verifikasi',
        'verifying' => 'Memverifikasi...',

        'invalid' => 'Kode pemulihan tidak valid.',
        'success' => 'Pemulihan akun berhasil.',
    ],

];
