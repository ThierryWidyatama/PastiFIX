<?php

use App\Events\Example;
use App\Models\Option;
use App\Livewire\Counter;
use App\Livewire\ShowPayload;
use Illuminate\Support\Facades\Route;

// KONTROLLER BAWAAN PROYEK TEMANMU
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahasaController;
use App\Http\Controllers\BidangHukumController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\JenisDokumenController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ModulePermissionController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PencarianController;
use App\Http\Controllers\SettingLandingPageController;
use App\Http\Controllers\TipeDokumenController;


/*
|--------------------------------------------------------------------------
| [PERBAIKAN BUG] KITA PISAHKAN DUA DASHBOARD CONTROLLER
|--------------------------------------------------------------------------
|
| 1. Ini adalah Controller bawaan Metronic untuk Admin (/dashboard)
|
*/
use App\Http\Controllers\DashboardController;

/*
|
| 2. Ini adalah Controller YANG KITA BUAT untuk User (/profil)
| Kita kasih 'alias' (nama panggilan) 'UserDashboardController' biar nggak tabrakan.
|
*/
use App\Http\Controllers\User\DashboardController as UserDashboardController;


/*
|--------------------------------------------------------------------------
| Rute Publik (Landing Page & Auth)
|--------------------------------------------------------------------------
*/
// Rute Landing Page (Ini sudah benar)
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Rute Autentikasi (INI BLOK PERBAIKANNYA)
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('login.auth');
Route::get('/registration', [AuthController::class, 'registration'])->name('register');
Route::post('/post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('2fa/verify', [TwoFactorController::class, 'showVerifyForm'])->name('2fa.verify');
Route::post('2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.submit');
Route::get('2fa/verify-link', [TwoFactorController::class, 'verifyLink'])->name('2fa.verify.link');

Route::get('/produk-hukum', [PencarianController::class, 'index'])->name('produk-hukum');


/*
|--------------------------------------------------------------------------
| Rute yang Dilindungi (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Rute Dashboard ADMIN (Bawaan Metronic)
    | Menggunakan "DashboardController" (tanpa alias)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    //User Profile Bawaan Metronic
    Route::get('/user-profile', [UserProfileController::class, 'index'])->name('user-profile.index');
    Route::post('/user-profile/update/{id}', [UserProfileController::class, 'updateProfile'])->name('user-profile.update');
    Route::post('/user-profile/update/password/{id}', [UserProfileController::class, 'updatePassword'])->name('user-profile.password.update');
    Route::post('/user-profile/update/twofa/{id}', [UserProfileController::class, 'updatetwofa'])->name('user-profile.twofa.update');
    Route::post('/user-profile/update/email/{id}', [UserProfileController::class, 'updateemail'])->name('user-profile.email.update');
    Route::get('/user-profile/verify/email/{id}', [UserProfileController::class, 'verifyemail'])->name('user-profile.email.verify');
    Route::get('/user-profile/verify/verify-email', [UserProfileController::class, 'verifyEmailLink'])->name('user-profile.email.verify-link');

    //User Management Bawaan Metronic
    Route::resource('user', UserController::class);
    Route::get('/user-destroy/{id}', [UserController::class, 'destroy']);
    Route::get('/user-reset/{id}', [UserController::class, 'resetPass']);
    Route::get('/user-reset-status/{id}/{val}', [UserController::class, 'changeStatus']);
    Route::get('/user-data', [UserController::class, 'data'])->name('user.data');
    Route::get('/user-pdf', [UserController::class, 'loadPdf']);
    Route::get('/user-excel', [UserController::class, 'loadExcel']);
    Route::get('/user-form-import', [UserController::class, 'formImport']);
    Route::post('/user-proses-import', [UserController::class, 'prosesImport']);

    //Module Bawaan Metronic
    Route::prefix('modules')->group(function () {
        Route::get('/', [ModuleController::class, 'index'])->name('modules.index');
        Route::get('/json', [ModuleController::class, 'json']);
        Route::post('/sort', [ModuleController::class, 'sort']);
        Route::get('/delete/{id}', [ModuleController::class, 'destroy']);
        Route::get('get-modules-tree', [ModuleController::class, 'get_modules_tree'])->name('modules.tree');
        Route::post('sort-tree', [ModuleController::class, 'sort_tree'])->name('modules.sort_tree');
    });
    Route::resource('modules', ModuleController::class);

    //Log Bawaan Metronic
    Route::get('logs/data', [LogsController::class, 'data'])->name('logs.data');
    Route::resource('logs', LogsController::class);

    //Option Bawaan Metronic
    Route::resource('option', OptionController::class)->only(['index', 'update']);

    //Module Permission Bawaan Metronic
    Route::get('/module-permission', [ModulePermissionController::class, 'index'])->name('module-permission.index');
    Route::get('/module-permission/detail/{id}', [ModulePermissionController::class, 'show'])->name('module-permission.show');
    Route::get('/module-permission/data', [ModulePermissionController::class, 'data'])->name('module-permission.data');
    Route::get('/module-permission/create', [ModulePermissionController::class, 'create'])->name('module-permission.create');
    Route::post('/module-permission/store', [ModulePermissionController::class, 'store'])->name('module-permission.store');
    Route::get('/module-permission/edit/{id}', [ModulePermissionController::class, 'edit'])->name('module-permission.edit');
    Route::post('/module-permission/update', [ModulePermissionController::class, 'update'])->name('module-permission.update');
    Route::delete('/module-permission/delete/{id}', [ModulePermissionController::class, 'delete'])->name('module-permission.destroy');
    Route::get('/module-permission/roles/{id}', [ModulePermissionController::class, 'roles'])->name('module-permission.roles');
    Route::post('/module-permission/roles/store', [ModulePermissionController::class, 'roles_store'])->name('module-permission.role_store');

    // Setting Landing Page Bawaan Metronic
    Route::resource('setting-landing-page', SettingLandingPageController::class)->only(['index', 'update']);

    //Route Select2 Bawaan Metronic
    Route::post('master-tipe-dokumen/tipeDokumenSelect', [TipeDokumenController::class, 'tipeDokumenSelect'])->name('master-tipe-dokumen.tipeDokumenSelect');
    Route::post('master-jenis-dokumen/jenisDokumenSelect', [JenisDokumenController::class, 'jenisDokumenSelect'])->name('master-jenis-dokumen.jenisDokumenSelect');
    Route::post('master-bidang-hukum/bidHukumSelect', [BidangHukumController::class, 'bidHukumSelect'])->name('master-bidang-hukum.bidHukumSelect');
    Route::post('master-opd/opdSelect', [OpdController::class, 'opdSelect'])->name('master-opd.opdSelect');
    Route::post('master-bahasa/bahasaSelect', [BahasaController::class, 'bahasaSelect'])->name('master-bahasa.bahasaSelect');


    /*
    |--------------------------------------------------------------------------
    | Rute Dashboard USER (Buatan Kita)
    | Menggunakan "UserDashboardController" (dengan alias)
    |--------------------------------------------------------------------------
    */
    Route::get('/profil', [UserDashboardController::class, 'showProfile'])->name('profil');
    
    Route::get('/profil/activity', function () {
        return view('user.activity');
    })->name('profil.activity'); // <-- [FIX] Kasih nama

    Route::get('/profil/settings', function () {
        return view('user.settings');
    })->name('profil.settings'); // <-- [FIX] Kasih nama

    Route::get('/profil/activity/detail', function () {
        return view('user.activity-detail');
    })->name('profil.activity.detail'); // <-- [FIX] Kasih nama

});