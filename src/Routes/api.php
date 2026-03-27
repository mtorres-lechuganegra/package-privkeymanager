<?php

use Illuminate\Support\Facades\Route;
use LechugaNegra\PrivKeyManager\Http\Controllers\PrivKeyController;

Route::prefix('api/privkey')->name('api.auth.')->group(function () {
    Route::post('/authenticate', [PrivKeyController::class, 'authenticate'])->name('authenticate'); // Autenticación
});
