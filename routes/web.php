<?php

use App\Livewire\Customer\Index as CustomerIndex;
use App\Livewire\Customer\Show as CustomerShow;
use App\Livewire\Loan\Index as LoanIndex;
use App\Livewire\Meeting\Index as MeetingIndex;
use App\Livewire\Member\Index as MemberIndex;
use App\Livewire\Overview;
use App\Livewire\Payment\Detail as PaymentDetail;
use App\Livewire\Payment\Index as PaymentIndex;
use App\Livewire\Payment\Show as PaymentShow;
use App\Livewire\Report\Customer as ReportCustomer;
use App\Livewire\Report\Monthly as ReportMonthly;
use App\Livewire\Saving\Index as SavingIndex;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/overview');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/overview', Overview::class)
        ->name('overview');

    Route::get('/meetings', MeetingIndex::class)
        ->name('meeting.index');

    Route::get('/members', MemberIndex::class)
        ->name('member.index');

    Route::get('/customers', CustomerIndex::class)
        ->name('customer.index');
    Route::get('/customers/{customer}', CustomerShow::class)
        ->name('customer.show');

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

    Route::get('/report/monthly', ReportMonthly::class)
        ->name('report.monthly');
    Route::get('/report/customer', ReportCustomer::class)
        ->name('report.customer');
});

require __DIR__ . '/settings.php';
