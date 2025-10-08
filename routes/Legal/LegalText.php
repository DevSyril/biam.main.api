<?php

use App\Http\Controllers\LegalContext\LegalTextController;
use Illuminate\Support\Facades\Route;

Route::prefix('legal')->group(function () {
    Route::get('texts', [LegalTextController::class, 'index']);
    Route::post('texts/create', [LegalTextController::class, 'store']);
    Route::get('texts/show/{id}', [LegalTextController::class, 'show']);
    Route::post('texts/update/{id}', [LegalTextController::class, 'update']);
    Route::delete('texts/delete/{id}', [LegalTextController::class, 'destroy']);
    Route::post('texts/abrogate/{id}', [LegalTextController::class, 'abrogate']);
});