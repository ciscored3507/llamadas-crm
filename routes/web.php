<?php

# use Illuminate\Support\Facades\Route;

# Route::get('/', function () {
#    return view('welcome');
# });

use App\Http\Controllers\CallController;


Route::get('/calls', [CallController::class, 'create'])->name('calls.create');
Route::post('/calls', [CallController::class, 'store'])->name('calls.store');
