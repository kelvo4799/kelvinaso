<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::post('/contact/send', [ContactController::class, 'create']);

Route::get('/test', function(){
    return 'Test Api Link';
});
