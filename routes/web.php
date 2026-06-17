<?php

use App\Livewire\Dashboard;
use App\Livewire\Member\Index;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', Dashboard::class)
        ->name('dashboard');

    Route::get('/member', Index::class)
        ->name('member.index');
});

require __DIR__ . '/settings.php';
