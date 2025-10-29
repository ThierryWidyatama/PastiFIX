<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});
Route::get('/profil', function () {
    return view('user.profile');
});
Route::get('/profil/activity', function () {
    return view('user.activity');
});
Route::get('/profil/settings', function () {
    return view('user.settings');
});
Route::get('/profil/activity/detail', function () {
    return view('user.activity-detail');
});