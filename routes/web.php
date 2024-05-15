<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;


Route::get('/{vue_capture?}', IndexController::class)->where('vue_capture', '[\/\w\.-]*');

