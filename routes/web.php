<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('lead-capture-view');
});

Route::get('/management', function () {
    return view('leads-management-view');
});

