<?php

use App\Http\Controllers\Api\ManageWallet\SaveWalletAddress;
use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;

Route::middleware(['auth'])->group(function () {
    Route::post('wallet/connect', SaveWalletAddress::class)->name('wallet.save');
    Route::post('wallet/disconnect', [SaveWalletAddress::class, 'disconnect'])->name('wallet.disconnect');
});
