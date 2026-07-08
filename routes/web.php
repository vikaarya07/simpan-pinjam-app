<?php

use App\Livewire\Dashboard;
use App\Livewire\Member\Index as MemberIndex;
use App\Livewire\Meeting\Index as MeetingIndex;
use App\Livewire\Saving\Index as SavingIndex;
use App\Livewire\Loan\Index as LoanIndex;
use App\Livewire\Payment\Index as PaymentIndex;
use App\Livewire\Payment\Show as PaymentShow;
use App\Livewire\Payment\Detail as PaymentDetail;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', Dashboard::class)
        ->name('dashboard');

    Route::get('/members', MemberIndex::class)
        ->name('member.index');

    Route::get('/meetings', MeetingIndex::class)
        ->name('meeting.index');

    Route::get('/savings', SavingIndex::class)
        ->name('saving.index');

    Route::get('/loans', LoanIndex::class)
        ->name('loan.index');

    Route::get('/payments', PaymentIndex::class)
        ->name('payment.index');
    Route::get('/payment/{meeting}', PaymentShow::class)
        ->name('payment.show');
    Route::get('/payment/{payment}/detail', PaymentDetail::class)
        ->name('payment.detail');
});

require __DIR__ . '/settings.php';
