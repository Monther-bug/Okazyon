<?php
use Illuminate\Support\Facades\Route;

Route::get('/search', function() { return 'one slash'; });
Route::get('//search', function() { return 'two slashes'; });

