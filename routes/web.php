<?php

use App\Livewire\Dashboard;
use App\Livewire\Member\Index as MemberIndex;
use App\Livewire\Saving\Index as SavingIndex;
use App\Livewire\Loan\Index as LoanIndex;
use App\Livewire\Payment\Index as PaymentIndex;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', Dashboard::class)
        ->name('dashboard');

    Route::get('/member', MemberIndex::class)
        ->name('member.index');

    Route::get('/saving', SavingIndex::class)
        ->name('saving.index');

    Route::get('/loan', LoanIndex::class)
        ->name('loan.index');

    Route::get('/payment', PaymentIndex::class)
        ->name('payment.index');
});

require __DIR__ . '/settings.php';
