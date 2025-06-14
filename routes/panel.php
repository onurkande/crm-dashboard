<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\ProductCategoryController;
use App\Http\Controllers\Panel\TemplateEditorController;
use App\Http\Controllers\Panel\PreviewExportController;
use App\Http\Controllers\Panel\IndexController;
use App\Http\Controllers\Panel\StatisticsReportsController;
/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin panel routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "admin" middleware group.
|
*/


Route::get('/', [IndexController::class, 'index'])->name('dashboard');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/add-product', [ProductController::class, 'create'])->name('add-product');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::get('/template-editor/{product}', [TemplateEditorController::class, 'index'])->name('template-editor');
Route::put('/template-editor/{product}', [TemplateEditorController::class, 'update'])->name('template-editor.update');
Route::get('/preview-export/{product}', [PreviewExportController::class, 'show'])->name('preview-export');

Route::post('/products/{product}/status', [ProductController::class, 'updateStatus'])->name('products.status.update');
Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
Route::get('/products/{product}', [ProductController::class, 'destroy'])->name('products.delete');
Route::post('/products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');

Route::get('/preview-export/{product}/pdf', [PreviewExportController::class, 'downloadPDF'])->name('preview-export.pdf');
Route::get('/dashboard/export-pdf', [IndexController::class, 'exportPdf'])->name('dashboard.export-pdf');

// Category Routes
Route::get('/categories', [ProductCategoryController::class, 'index'])->name('categories');
Route::post('/categories', [ProductCategoryController::class, 'store'])->name('categories.store');
Route::put('/categories/{category}', [ProductCategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [ProductCategoryController::class, 'destroy'])->name('categories.destroy');


Route::get('/statistics-reports', [StatisticsReportsController::class, 'index'])->name('statistics-reports');

Route::get('/label-scheduler', function () {
    return view('panel.label-scheduler');
})->name('label-scheduler');

Route::get('/account-settings', function () {
    return view('panel.account-settings');
})->name('account-settings');

Route::get('/support-help-center', function () {
    return view('panel.support-help-center');
})->name('support-help-center');

Route::post('/template-editor/{product}/report-faulty', [TemplateEditorController::class, 'reportFaulty'])->name('template-editor.report-faulty');
Route::post('/template-editor/{product}/retranslate', [TemplateEditorController::class, 'retranslate'])->name('template-editor.retranslate');

Route::get('/faulty-translations', [ProductController::class, 'faultyTranslations'])->name('faulty-translations');
