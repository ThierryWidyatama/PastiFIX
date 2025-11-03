<?php

use App\Events\Example;
use App\Models\Option;
use App\Livewire\Counter;
use App\Livewire\ShowPayload;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahasaController;
use App\Http\Controllers\BidangHukumController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ReverbController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisDokumenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\MatkulMahasiswaController;
use App\Http\Controllers\ModulePermissionController;
use App\Http\Controllers\ModuleSocialMediaController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PencarianController;
use App\Http\Controllers\ProdukHukumController;
use App\Http\Controllers\SettingLandingPageController;
use App\Http\Controllers\TipeDokumenController;

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/home', [LandingPageController::class, 'index'])->name('home');

Route::get('/login', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return app(AuthController::class)->index();
})->name('login');


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('login.auth');
Route::get('/registration', [AuthController::class, 'registration'])->name('register');
Route::post('/post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('2fa/verify', [TwoFactorController::class, 'showVerifyForm'])->name('2fa.verify');
Route::post('2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.submit');
Route::get('2fa/verify-link', [TwoFactorController::class, 'verifyLink'])->name('2fa.verify.link');

Route::get('/produk-hukum', [PencarianController::class, 'index'])->name('produk-hukum');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    //User Profile
    Route::get('/user-profile', [UserProfileController::class, 'index'])->name('user-profile.index');
    Route::post('/user-profile/update/{id}', [UserProfileController::class, 'updateProfile'])->name('user-profile.update');
    Route::post('/user-profile/update/password/{id}', [UserProfileController::class, 'updatePassword'])->name('user-profile.password.update');
    Route::post('/user-profile/update/twofa/{id}', [UserProfileController::class, 'updatetwofa'])->name('user-profile.twofa.update');
    Route::post('/user-profile/update/email/{id}', [UserProfileController::class, 'updateemail'])->name('user-profile.email.update');
    Route::get('/user-profile/verify/email/{id}', [UserProfileController::class, 'verifyemail'])->name('user-profile.email.verify');
    Route::get('/user-profile/verify/verify-email', [UserProfileController::class, 'verifyEmailLink'])->name('user-profile.email.verify-link');

    //User
    Route::resource('user', UserController::class);
    Route::get('/user-destroy/{id}', [UserController::class, 'destroy']);
    Route::get('/user-reset/{id}', [UserController::class, 'resetPass']);
    Route::get('/user-reset-status/{id}/{val}', [UserController::class, 'changeStatus']);
    Route::get('/user-data', [UserController::class, 'data'])->name('user.data');
    Route::get('/user-pdf', [UserController::class, 'loadPdf']);
    Route::get('/user-excel', [UserController::class, 'loadExcel']);
    Route::get('/user-form-import', [UserController::class, 'formImport']);
    Route::post('/user-proses-import', [UserController::class, 'prosesImport']);

    //Module
    Route::prefix('modules')->group(function () {
        Route::get('/', [ModuleController::class, 'index'])->name('modules.index');
        Route::get('/json', [ModuleController::class, 'json']);
        Route::post('/sort', [ModuleController::class, 'sort']);
        Route::get('/delete/{id}', [ModuleController::class, 'destroy']);
        Route::get('get-modules-tree', [ModuleController::class, 'get_modules_tree'])->name('modules.tree');
        Route::post('sort-tree', [ModuleController::class, 'sort_tree'])->name('modules.sort_tree');
    });
    Route::resource('modules', ModuleController::class);

    //log
    Route::get('logs/data', [LogsController::class, 'data'])->name('logs.data');
    Route::resource('logs', LogsController::class);

    //Option
    Route::resource('option', OptionController::class)->only(['index', 'update']);

    //Fakultas
    // Route::get('fakultas/data', [FakultasController::class, 'data'])->name('fakultas.data');
    // Route::post('fakultas/select', [FakultasController::class, 'fakultasSelect'])->name('fakultas.select');
    // Route::resource('fakultas', FakultasController::class);

    //Mata Kuliah
    // Route::get('mata-kuliah/data', [MataKuliahController::class, 'data'])->name('mata-kuliah.data');
    // Route::get('mata-kuliah/data', [MataKuliahController::class, 'data'])->name('mata-kuliah.data');
    // Route::resource('mata-kuliah', MataKuliahController::class);

    //Mahasiswa
    // Route::get('mahasiswa/data', [MahasiswaController::class, 'data'])->name('mahasiswa.data');
    // Route::resource('mahasiswa', MahasiswaController::class);

    //Matkul Mahasiswa
    // Route::get('matkul-mahasiswa/data', [MatkulMahasiswaController::class, 'data'])->name('matkul-mahasiswa.data');
    // Route::post('matkul-mahasiswa/select', [MatkulMahasiswaController::class, 'matkulMhsSelect'])->name('matkul-mahasiswa.select');
    // Route::get('matkul-mahasiswa/{id}', [MatkulMahasiswaController::class, 'index'])->name('matkul-mahasiswa.index');
    // Route::get('matkul-mahasiswa/{id}/create', [MatkulMahasiswaController::class, 'create'])->name('matkul-mahasiswa.create');
    // Route::post('matkul-mahasiswa/store', [MatkulMahasiswaController::class, 'store'])->name('matkul-mahasiswa.store');
    // Route::resource('matkul-mahasiswa', MatkulMahasiswaController::class)->except(['index', 'create']);

    //Module Permission
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

    // Setting Landing Page
    Route::resource('setting-landing-page', SettingLandingPageController::class)->only(['index', 'update']);

    // Module Social Media
    // Route::get('master-social-media/data', [ModuleSocialMediaController::class, 'data'])->name('master-social-media.data');
    // Route::resource('master-social-media', ModuleSocialMediaController::class);

    // Master Produk Hukum
    Route::get('master-produk-hukum/data', [ProdukHukumController::class, 'data'])->name('master-produk-hukum.data');
    Route::get('master-produk-hukum/subjek', [ProdukHukumController::class, 'subjekSelect'])->name('master-produk-hukum.subjekSelect');
    Route::post('master-produk-hukum/selectProdukHukum', [ProdukHukumController::class, 'selectProdukHukum'])->name('master-produk-hukum.selectProdukHukum');
    Route::resource('master-produk-hukum', ProdukHukumController::class);

    Route::get('master-tipe-dokumen/data', [TipeDokumenController::class, 'data'])->name('master-tipe-dokumen.data');
    Route::resource('master-tipe-dokumen', TipeDokumenController::class);

    Route::get('master-jenis-dokumen/data', [JenisDokumenController::class, 'data'])->name('master-jenis-dokumen.data');
    Route::resource('master-jenis-dokumen', JenisDokumenController::class);

    Route::get('master-bidang-hukum/data', [BidangHukumController::class, 'data'])->name('master-bidang-hukum.data');
    Route::resource('master-bidang-hukum', BidangHukumController::class);
    
    Route::get('master-bahasa/data', [BahasaController::class, 'data'])->name('master-bahasa.data');
    Route::resource('master-bahasa', BahasaController::class);

    Route::get('master-opd/data', [OpdController::class, 'data'])->name('master-opd.data');
    Route::resource('master-opd', OpdController::class);


    //route utk select2
    Route::post('master-tipe-dokumen/tipeDokumenSelect', [TipeDokumenController::class, 'tipeDokumenSelect'])->name('master-tipe-dokumen.tipeDokumenSelect');
    Route::post('master-jenis-dokumen/jenisDokumenSelect', [JenisDokumenController::class, 'jenisDokumenSelect'])->name('master-jenis-dokumen.jenisDokumenSelect');
    Route::post('master-bidang-hukum/bidHukumSelect', [BidangHukumController::class, 'bidHukumSelect'])->name('master-bidang-hukum.bidHukumSelect');
    Route::post('master-opd/opdSelect', [OpdController::class, 'opdSelect'])->name('master-opd.opdSelect');
    Route::post('master-bahasa/bahasaSelect', [BahasaController::class, 'bahasaSelect'])->name('master-bahasa.bahasaSelect');



});
