<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Livewire\Chat;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/',Chat::class)->name('chat');
    Route::resource('contacts',ContactController::class)->names('contacts');
    Route::resource('groups',ChatController::class)->names('groups');
});

Route::get('desc',function(){

    return Hash::check("password",'$2y$10$3lDG9OnWhDjA7tArus92eep.7Sm6e0etM7j1Wg8ikh2IBhfywrn1y');
    //return Hash::info('$2y$10$3lDG9OnWhDjA7tArus92eep.7Sm6e0etM7j1Wg8ikh2IBhfywrn1y');
});