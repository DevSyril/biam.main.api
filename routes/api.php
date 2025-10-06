<?php

use App\Http\Controllers\Documents\DocumentController;
use App\Http\Controllers\Documents\TemplateController;
use App\Http\Controllers\Documents\TemplateSectionController;
use App\Http\Controllers\Fields\FieldController;
use App\Http\Controllers\Fields\TemplateFieldController;
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

    Route::get('templates/sections', [TemplateSectionController::class, 'index']);
    Route::get('templates/sections/show/{id}', [TemplateSectionController::class, 'show']);
    Route::post('templates/sections/create', [TemplateSectionController::class, 'store']);
    Route::post('templates/sections/update/{id}', [TemplateSectionController::class, 'update']);
    Route::delete('templates/sections/delete/{id}', [TemplateSectionController::class, 'destroy']);
    Route::get('templates/sections/template/{templateId}', [TemplateSectionController::class, 'getTemplateSections']);

    Route::get('fields', [FieldController::class, 'index']);
    Route::get('fields/show/{id}', [FieldController::class, 'show']);
    Route::post('fields/create', [FieldController::class, 'store']);
    Route::post('fields/update/{id}', [FieldController::class, 'update']);
    Route::delete('fields/delete/{id}', [FieldController::class, 'destroy']);

    Route::get('fields/template-fields', [TemplateFieldController::class, 'index']);
    Route::get('fields/template-fields/show/{id}', [TemplateFieldController::class, 'show']);
    Route::post('fields/template-fields/create', [TemplateFieldController::class, 'store']);
    Route::post('fields/template-fields/update/{id}', [TemplateFieldController::class, 'update']);
    Route::delete('fields/template-fields/delete/{id}', [TemplateFieldController::class, 'destroy']);



});

