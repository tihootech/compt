<?php

use Illuminate\Support\Facades\Route;
Route::redirect('/', 'landing');
Route::get('landing', 'LandingController@landing');
