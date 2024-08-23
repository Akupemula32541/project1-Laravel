<?php

use App\Http\Controllers\zoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

route::resource('zoom', zoomController::class);