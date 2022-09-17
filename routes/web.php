<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Livewire\Chat;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/',Chat::class)->name('chat');
    Route::resource('contacts',ContactController::class)->names('contacts');
    Route::resource('groups',ChatController::class)->names('groups');
});
