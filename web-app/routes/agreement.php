<?php

use App\Livewire\Dashboard\AgreementList;
use Livewire\Volt\Volt;

use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::get('agreements', AgreementList::class)->name('agreements.index');;
    // Volt::route('agreements', 'dashboard.agreements')->name('agreements.index');
    Volt::route('agreements-details', 'dashboard.agreement-details')->name('agreements.show');
});
