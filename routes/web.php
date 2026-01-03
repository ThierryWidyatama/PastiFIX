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
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\MandorController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\AdminDashboardController;


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
// routes/web.php
Route::get('/profil-dummy', [\App\Http\Controllers\ProfilController::class, 'index'])->name('profil.dummy');
Route::post('/profil-dummy/upload', [\App\Http\Controllers\ProfilController::class, 'upload'])->name('profil.upload');
Route::post('/payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);

// Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ServiceController::class, 'detail'])
    ->name('services.detail')
    ->whereUuid('id'); // <-- INI MANTRA AJAIBNYA

// Rute Autentikasi (INI BLOK PERBAIKANNYA)
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('login.auth');
Route::get('/registration', [AuthController::class, 'registration'])->name('register');
Route::post('/post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('/verify-email/{id}', [AuthController::class, 'showVerifyForm'])->name('verification.notice');
Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('2fa/verify', [TwoFactorController::class, 'showVerifyForm'])->name('2fa.verify');
Route::post('2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.submit');
Route::get('2fa/verify-link', [TwoFactorController::class, 'verifyLink'])->name('2fa.verify.link');

Route::get('/produk-hukum', [PencarianController::class, 'index'])->name('produk-hukum');

// Rute untuk melihat semua review
Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');

// Route Lupa Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetCode'])->name('password.email');

    Route::get('/reset-password/{id}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset.form');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


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

    Route::get('/payment/{id}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');

    /*
    |--------------------------------------------------------------------------
    | Rute Dashboard USER (Buatan Kita)
    | Menggunakan "UserDashboardController" (dengan alias)
    |--------------------------------------------------------------------------
    */
    Route::get('/profil', [UserDashboardController::class, 'showProfile'])->name('profil');

    Route::post('/profil', [UserDashboardController::class, 'updateProfile'])->name('profil.update');
    
    Route::get('/profil/activity', [UserDashboardController::class, 'showActivity'])->name('profil.activity');

    Route::get('/profil/settings', function () {
        return view('user.settings');
    })->name('profil.settings'); // <-- [FIX] Kasih nama

    Route::get('/profil/activity/{id}', [UserDashboardController::class, 'showActivityDetail'])
        ->name('profil.activity.detail');

    Route::post('/profil/settings/password', [UserDashboardController::class, 'updatePassword'])
        ->name('profil.settings.password');

    Route::post('/profil/settings/email', [UserDashboardController::class, 'updateEmail'])
        ->name('profil.settings.email');

    Route::put('/profil/address/{id}', [UserDashboardController::class, 'updateAddress'])->name('address.update');
    Route::delete('/profil/address/{id}', [UserDashboardController::class, 'destroyAddress'])->name('address.destroy');
    Route::post('/profil/address/{id}/primary', [UserDashboardController::class, 'setPrimaryAddress'])->name('address.primary');

    /*
    |--------------------------------------------------------------------------
    | Rute Services
    | Services atau kategori layanan
    |--------------------------------------------------------------------------
    */
        
    Route::get('/services/checkout', [ServiceController::class, 'showCheckout'])->name('services.checkout');

    // [BARU] Route untuk memproses pesanan
    Route::post('/services/order', [OrderController::class, 'store'])->name('order.store');

    // [BARU] Route untuk menambah alamat via Modal Checkout (biar gak error nanti)
    Route::post('/services/address/store', [UserDashboardController::class, 'storeAddressFromCheckout'])->name('address.store');

    Route::get('/services/payment', function () {
        return view('services.payment');
    })->name('services.payment');

    Route::get('/services/order-success', function () {
        return view('services.order');
    })->name('services.order');

    Route::get('/services/my-orders', function () {
        return view('services.my-orders');
    })->name('services.my-orders');


    /*
    |--------------------------------------------------------------------------
    | Rute CRUD Kategori (FIXED)
    |--------------------------------------------------------------------------
    */
    // [FIX] Kita pakai 'prefix' dan 'name' biar rapi
    Route::prefix('kategori')->name('kategori.')->middleware(['auth'])->group(function () {
        
        // [FIX] Halaman daftar sekarang di /kategori/daftarkategori
        // NAMUN namanya tetap 'kategori.index' (Biar view kita nggak perlu diubah)
        Route::get('/daftarkategori', [KategoriController::class, 'index'])->name('index');

        // Ini route-mu yang sudah ada
        Route::get('/tambahkategori', [KategoriController::class, 'create'])->name('create');

        // Route 'store' sekarang otomatis mengarah ke POST /kategori
        Route::post('/', [KategoriController::class, 'store'])->name('store');

        // Route 'edit' sekarang otomatis mengarah ke GET /kategori/{id}/edit
        Route::get('/{category}/edit', [KategoriController::class, 'edit'])->name('edit');

        // Route 'update' sekarang otomatis mengarah ke PUT /kategori/{id}
        Route::put('/{category}', [KategoriController::class, 'update'])->name('update');

        // Route 'destroy'
        Route::delete('/{category}', [KategoriController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Rute Manajemen Pesanan (Admin)
    |--------------------------------------------------------------------------
    */
    Route::prefix('pesanan')->name('admin.orders.')->group(function () {
        
        // Route Index, Show, Update yang lama...
        Route::get('/status-pesanan', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminOrderController::class, 'show'])->name('show');
        Route::put('/{id}', [AdminOrderController::class, 'update'])->name('update');

        // [BARU] Route untuk Timeline & Cost
        Route::post('/{id}/timeline', [AdminOrderController::class, 'storeTimeline'])->name('timeline.store');
        Route::delete('/timeline/{timeline_id}', [AdminOrderController::class, 'destroyTimeline'])->name('timeline.destroy');

        Route::post('/{id}/cost', [AdminOrderController::class, 'storeCost'])->name('cost.store');
        Route::delete('/cost/{cost_id}', [AdminOrderController::class, 'destroyCost'])->name('cost.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Rute Manajemen Mandor
    |--------------------------------------------------------------------------
    */
    Route::prefix('mandor')->name('mandor.')->group(function () {
        Route::get('/daftar', [MandorController::class, 'index'])->name('index');
        Route::get('/tambah', [MandorController::class, 'create'])->name('create');
        Route::post('/simpan', [MandorController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [MandorController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [MandorController::class, 'update'])->name('update');
        Route::delete('/hapus/{id}', [MandorController::class, 'destroy'])->name('destroy');
    });

    // Route Simpan Review
    Route::post('/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');
    Route::post('/pesanan/{id}/batal', [App\Http\Controllers\OrderController::class, 'requestCancel'])->name('profil.activity.cancel');

    // Route Admin Approve/Reject Batal
    Route::post('/orders/{id}/approve-cancel', [App\Http\Controllers\AdminOrderController::class, 'approveCancel'])->name('admin.orders.approve_cancel');
    Route::post('/orders/{id}/reject-cancel', [App\Http\Controllers\AdminOrderController::class, 'rejectCancel'])->name('admin.orders.reject_cancel');

    // Route Proxy Peta (Biar gak kena CORS Error)
    Route::get('/geocode/reverse', [UserDashboardController::class, 'proxyReverseGeocode'])->name('geocode.reverse');
    Route::get('/geocode/search', [UserDashboardController::class, 'proxySearchGeocode'])->name('geocode.search');

    // Route Download Invoice PDF
    Route::get('/invoice/{id}', [UserDashboardController::class, 'downloadInvoice'])->name('invoice.download');

    // Route Export Excel
    Route::get('/admin/export/revenue', [DashboardController::class, 'exportExcel'])->name('admin.export.revenue');
    
    // Route Import Data
    Route::get('/admin/import/template', [DashboardController::class, 'downloadTemplate'])->name('admin.import.template');
    Route::post('/admin/import/store', [DashboardController::class, 'importRevenue'])->name('admin.import.store');
    Route::delete('/admin/import/reset', [DashboardController::class, 'resetRevenue'])->name('admin.import.reset');
});