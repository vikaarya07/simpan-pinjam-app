<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General Messages
    |--------------------------------------------------------------------------
    */

    'success' => 'Berhasil.',
    'error' => 'Terjadi kesalahan.',
    'warning' => 'Peringatan.',
    'info' => 'Informasi.',

    /*
    |--------------------------------------------------------------------------
    | CRUD Messages
    |--------------------------------------------------------------------------
    */

    'created' => ':attribute berhasil dibuat.',
    'updated' => ':attribute berhasil diperbarui.',
    'deleted' => ':attribute berhasil dihapus.',
    'restored' => ':attribute berhasil dipulihkan.',

    'create_failed' => ':attribute gagal dibuat.',
    'update_failed' => ':attribute gagal diperbarui.',
    'delete_failed' => ':attribute gagal dihapus.',

    'not_found' => ':attribute tidak ditemukan.',
    'already_exists' => ':attribute sudah ada.',
    'cannot_delete' => ':attribute tidak dapat dihapus.',
    'cannot_update' => ':attribute tidak dapat diperbarui.',

    /*
    |--------------------------------------------------------------------------
    | Confirmation Messages
    |--------------------------------------------------------------------------
    */

    'confirm' => [
        'title' => 'Apakah Anda yakin?',
        'delete' => 'Data yang dihapus tidak dapat dikembalikan.',
        'delete_title' => 'Hapus data?',
        'delete_text' => 'Data ini akan dihapus secara permanen.',
        'cancel' => 'Batal',
        'confirm' => 'Ya, lanjutkan',
        'delete_confirm' => 'Ya, hapus',
    ],

    /*
    |--------------------------------------------------------------------------
    | Form Messages
    |--------------------------------------------------------------------------
    */

    'form' => [
        'saved' => 'Data berhasil disimpan.',
        'save_failed' => 'Data gagal disimpan.',
        'reset' => 'Form berhasil direset.',
        'invalid' => 'Mohon periksa kembali data yang dimasukkan.',
        'no_changes' => 'Tidak ada perubahan yang disimpan.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Search & Filter Messages
    |--------------------------------------------------------------------------
    */

    'search' => [
        'no_results' => 'Data tidak ditemukan.',
        'no_data' => 'Belum ada data.',
        'empty' => 'Pencarian tidak menghasilkan data.',
    ],

    'filter' => [
        'applied' => 'Filter berhasil diterapkan.',
        'reset' => 'Filter berhasil direset.',
        'no_results' => 'Tidak ada data yang sesuai dengan filter.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Member / Customer Messages
    |--------------------------------------------------------------------------
    */

    'member' => [
        'created' => 'Nasabah berhasil ditambahkan.',
        'updated' => 'Data nasabah berhasil diperbarui.',
        'deleted' => 'Nasabah berhasil dihapus.',
        'not_found' => 'Nasabah tidak ditemukan.',
        'has_loans' => 'Nasabah tidak dapat dihapus karena masih memiliki pinjaman.',
        'has_active_loan' => 'Nasabah masih memiliki pinjaman yang berjalan.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Loan Messages
    |--------------------------------------------------------------------------
    */

    'loan' => [
        'created' => 'Pinjaman berhasil dibuat.',
        'updated' => 'Pinjaman berhasil diperbarui.',
        'deleted' => 'Pinjaman berhasil dihapus.',
        'not_found' => 'Pinjaman tidak ditemukan.',

        'insufficient_saving' => 'Saldo simpanan tidak mencukupi untuk membuat pinjaman.',
        'invalid_principal' => 'Pokok pinjaman tidak valid.',
        'principal_must_greater' => 'Pokok pinjaman baru harus lebih besar dari sisa pinjaman sebelumnya.',
        'previous_loan_not_found' => 'Pinjaman sebelumnya tidak ditemukan.',
        'previous_loan_not_running' => 'Pinjaman sebelumnya tidak sedang berjalan.',
        'maximum_installment' => 'Pinjaman telah mencapai batas maksimal angsuran.',
        'cannot_delete_paid' => 'Pinjaman yang telah memiliki pembayaran tidak dapat dihapus.',
        'cannot_update_paid' => 'Pinjaman yang telah memiliki pembayaran tidak dapat diperbarui.',

        'overdue_created' => 'Pinjaman jatuh tempo berhasil dibuat.',
        'overdue_not_available' => 'Pinjaman jatuh tempo belum dapat dibuat.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Messages
    |--------------------------------------------------------------------------
    */

    'payment' => [
        'created' => 'Pembayaran berhasil dicatat.',
        'updated' => 'Pembayaran berhasil diperbarui.',
        'deleted' => 'Pembayaran berhasil dihapus.',
        'not_found' => 'Pembayaran tidak ditemukan.',

        'saved' => 'Pembayaran berhasil disimpan.',
        'skipped' => 'Pembayaran ditandai sebagai dilewati.',
        'cleared' => 'Pembayaran berhasil dikonfirmasi.',

        'invalid_amount' => 'Jumlah pembayaran tidak valid.',
        'amount_must_positive' => 'Jumlah pembayaran harus lebih besar dari 0.',
        'maximum_installment' => 'Jumlah angsuran telah mencapai batas maksimal.',
        'already_paid' => 'Angsuran ini sudah dibayar.',
        'cannot_pay' => 'Pembayaran tidak dapat diproses.',
        'loan_not_found' => 'Pinjaman tidak ditemukan.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Saving Messages
    |--------------------------------------------------------------------------
    */

    'saving' => [
        'created' => 'Transaksi simpanan berhasil dibuat.',
        'updated' => 'Transaksi simpanan berhasil diperbarui.',
        'deleted' => 'Transaksi simpanan berhasil dihapus.',
        'not_found' => 'Transaksi simpanan tidak ditemukan.',

        'insufficient_balance' => 'Saldo simpanan tidak mencukupi.',
        'invalid_amount' => 'Jumlah simpanan tidak valid.',
        'balance_updated' => 'Saldo simpanan berhasil diperbarui.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Meeting Messages
    |--------------------------------------------------------------------------
    */

    'meeting' => [
        'created' => 'Pertemuan berhasil dibuat.',
        'updated' => 'Pertemuan berhasil diperbarui.',
        'deleted' => 'Pertemuan berhasil dihapus.',
        'not_found' => 'Pertemuan tidak ditemukan.',

        'already_exists' => 'Pertemuan pada tanggal tersebut sudah ada.',
        'has_payments' => 'Pertemuan tidak dapat dihapus karena sudah memiliki pembayaran.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Report Messages
    |--------------------------------------------------------------------------
    */

    'report' => [
        'generated' => 'Laporan berhasil dibuat.',
        'downloaded' => 'Laporan berhasil diunduh.',
        'sent' => 'Laporan berhasil dikirim.',
        'failed' => 'Laporan gagal dibuat.',
        'not_found' => 'Laporan tidak ditemukan.',
        'no_data' => 'Tidak ada data untuk ditampilkan dalam laporan.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Messages
    |--------------------------------------------------------------------------
    */

    'notification' => [
        'sent' => 'Notifikasi berhasil dikirim.',
        'failed' => 'Notifikasi gagal dikirim.',
        'created' => 'Notifikasi berhasil dibuat.',
        'deleted' => 'Notifikasi berhasil dihapus.',
        'not_found' => 'Notifikasi tidak ditemukan.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Messages
    |--------------------------------------------------------------------------
    */

    'auth' => [
        'login_success' => 'Berhasil masuk ke akun.',
        'login_failed' => 'Email atau kata sandi salah.',
        'logout_success' => 'Berhasil keluar dari akun.',
        'register_success' => 'Pendaftaran berhasil.',
        'password_changed' => 'Kata sandi berhasil diubah.',
        'password_reset' => 'Kata sandi berhasil direset.',
        'email_updated' => 'Alamat email berhasil diperbarui.',
        'verification_sent' => 'Tautan verifikasi telah dikirim ke email Anda.',
        'verification_success' => 'Email berhasil diverifikasi.',
    ],

    /*
    |--------------------------------------------------------------------------
    | File Messages
    |--------------------------------------------------------------------------
    */

    'file' => [
        'uploaded' => 'File berhasil diunggah.',
        'upload_failed' => 'File gagal diunggah.',
        'downloaded' => 'File berhasil diunduh.',
        'not_found' => 'File tidak ditemukan.',
        'invalid' => 'File tidak valid.',
    ],

    /*
    |--------------------------------------------------------------------------
    | PDF Messages
    |--------------------------------------------------------------------------
    */

    'pdf' => [
        'generated' => 'PDF berhasil dibuat.',
        'downloaded' => 'PDF berhasil diunduh.',
        'failed' => 'PDF gagal dibuat.',
    ],

];