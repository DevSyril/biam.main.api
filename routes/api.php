<?php

use App\Http\Controllers\Documents\DocumentController;
use App\Http\Controllers\Documents\TemplateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('app')->group(function () {

    Route::get('documents', [DocumentController::class, 'index']);
    Route::post('documents/create', [DocumentController::class, 'store']);
    Route::post('documents/update/{id}', [DocumentController::class, 'update']);
    Route::delete('documents/delete/{id}', [DocumentController::class, 'destroy']);
    Route::get('documents/category/{category}', [DocumentController::class, 'getByCategory']);
    Route::get('documents/show/{id}', [DocumentController::class, 'show']);
    Route::get('documents/search/', [DocumentController::class, 'searchDocuments']);


    Route::get('templates', [TemplateController::class, 'index']);
    Route::post('templates/create', [TemplateController::class, 'store']);
    Route::get('templates/show/{id}', [TemplateController::class, 'show']);
    Route::delete('templates/delete/{id}', [TemplateController::class, 'destroy']);
    Route::post('templates/update/{id}', [TemplateController::class, 'update']);
    Route::get('templates/perdocuments/{documentId}', [TemplateController::class, 'documentsTemplates']);

});
    
