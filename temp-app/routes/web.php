<?php

use Illuminate\Support\Facades\Route;

// Rute untuk Halaman Admin (Nanti akan kita beri pelindung Login)
Route::get('/admin', function () {
    return view('admin.dashboard');
});
