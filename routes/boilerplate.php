<?php

use App\Http\Controllers\Boilerplate\Auth\ForgotPasswordController;
use App\Http\Controllers\Boilerplate\Auth\LoginController;
use App\Http\Controllers\Boilerplate\Auth\RegisterController;
use App\Http\Controllers\Boilerplate\Auth\ResetPasswordController;
use App\Http\Controllers\Boilerplate\DatatablesController;
use App\Http\Controllers\Boilerplate\LanguageController;
use App\Http\Controllers\Boilerplate\Logs\LogViewerController;
use App\Http\Controllers\Boilerplate\Users\RolesController;
use App\Http\Controllers\Boilerplate\Users\UsersController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\JenisIdentitasController;
use App\Http\Controllers\JenisPaketController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\ActivityLogController;

Route::group([
    'prefix'     => config('boilerplate.app.prefix', ''),
    'domain'     => config('boilerplate.app.domain', ''),
    'middleware' => ['web', 'boilerplate.locale'],
    'as'         => 'boilerplate.',
], function () {
    Route::get('lang/{lang}', [LanguageController::class, 'switch'])->name('lang.switch');

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['boilerplate.guest']], function () {
        // Login
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.post');

        // Registration
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register'])->name('register.post');

        // Password reset
        Route::get('password/request', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.post');

        // First login
        Route::get('connect/{token?}', [UsersController::class, 'firstLogin'])->name('users.firstlogin');
        Route::post('connect/{token?}', [UsersController::class, 'firstLoginPost'])->name('users.firstlogin.post');
    });

    // Email verification
    Route::group(['middleware' => ['boilerplate.auth']], function () {
        Route::get('/email/verify', [RegisterController::class, 'emailVerify'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'emailVerifyRequest'])->name('verification.verify');
        Route::post('/email/verification-notification', [RegisterController::class, 'emailSendVerification'])->name('verification.send');
    });

    // Backend
    Route::group(['middleware' => ['boilerplate.auth', 'ability:admin,backend_access', 'boilerplate.emailverified']], function () {
        // Dashboard
        Route::get('/', [config('boilerplate.menu.dashboard'), 'index'])->name('dashboard');

        Route::post('keep-alive', [UsersController::class, 'keepAlive'])->name('keepalive');

        // Datatables
        Route::post('datatables/{slug}', [DatatablesController::class, 'make'])->name('datatables');

        // Roles and users
        Route::resource('roles', RolesController::class)->except('show')->middleware(['ability:admin,roles_crud']);
        Route::group(['middleware' => ['ability:admin,users_crud']], function () {
            Route::resource('users', UsersController::class)->except('show');
            Route::any('users/dt', [UsersController::class, 'datatable'])->name('users.datatable');
        });
        Route::get('userprofile', [UsersController::class, 'profile'])->name('user.profile');
        Route::post('userprofile', [UsersController::class, 'profilePost'])->name('user.profile.post');
        Route::post('userprofile/settings', [UsersController::class, 'storeSetting'])->name('settings');

        // Avatar
        Route::get('userprofile/avatar/url', [UsersController::class, 'getAvatarUrl'])->name('user.avatar.url');
        Route::post('userprofile/avatar/upload', [UsersController::class, 'avatarUpload'])->name('user.avatar.upload');
        Route::post('userprofile/avatar/gravatar', [UsersController::class, 'getAvatarFromGravatar'])->name('user.avatar.gravatar');
        Route::post('userprofile/avatar/delete', [UsersController::class, 'avatarDelete'])->name('user.avatar.delete');

        // Logs
        Route::group(['prefix' => 'logs', 'as' => 'logs.'], function () {
            Route::get('/', [LogViewerController::class, 'index'])->name('dashboard');
            Route::group(['prefix' => 'list'], function () {
                Route::get('/', [LogViewerController::class, 'listLogs'])->name('list');
                Route::delete('delete', [LogViewerController::class, 'delete'])->name('delete');

                Route::group(['prefix' => '{date}'], function () {
                    Route::get('/', [LogViewerController::class, 'show'])->name('show');
                    Route::get('download', [LogViewerController::class, 'download'])->name('download');
                    Route::get('{level}', [LogViewerController::class, 'showByLevel'])->name('filter');
                });
            });
        });

        //mobil
        Route::get('/mobil', [MobilController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,lihat_mobil'])
            ->name('mobil');
        Route::get('/buat-mobil', [MobilController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_mobil'])
            ->name('buat-mobil');
        Route::post('/buat-mobil', [MobilController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_mobil'])
            ->name('store-mobil');
        Route::get('/show-mobil/{id}', [MobilController::class, 'show'])
            ->middleware(['boilerplateauth', 'ability:admin,show_mobil'])
            ->name('show-mobil');
        Route::get('/edit-mobil/{id}', [MobilController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_mobil'])
            ->name('edit-mobil');
        Route::put('/edit-mobil/{id}', [MobilController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_mobil'])
            ->name('update-mobil');
        Route::delete('/delete-mobil/{id}', [MobilController::class, 'destroy'])
            ->middleware(['boilerplateauth', 'ability:admin,hapus_mobil'])
            ->name('delete-mobil');
        Route::delete('/nonaktif-mobil/{id}', [MobilController::class, 'nonaktif'])
            ->middleware(['boilerplateauth', 'ability:admin,hapus_mobil'])
            ->name('nonaktif-mobil');

        //driver
        Route::get('/driver', [DriverController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,lihat_driver'])
            ->name('driver');
        Route::get('/buat-driver', [DriverController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_driver'])
            ->name('buat-driver');
        Route::post('/buat-driver', [DriverController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_driver'])
            ->name('store-driver');
        Route::get('/show-driver/{id}', [DriverController::class, 'show'])
            ->middleware(['boilerplateauth', 'ability:admin,show_driver'])
            ->name('show-driver');
        Route::get('/edit-driver/{id}', [DriverController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_driver'])
            ->name('edit-driver');
        Route::put('/edit-driver/{id}', [DriverController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_driver'])
            ->name('update-driver');
        Route::delete('/delete-driver/{id}', [DriverController::class, 'destroy'])
            ->middleware(['boilerplateauth', 'ability:admin,hapus_driver'])
            ->name('delete-driver');

        //jenis identitas
        Route::get('/jenisidentitas', [JenisIdentitasController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,lihat_jenisidentitas'])
            ->name('jenisidentitas');
        Route::get('/buat-jenisidentitas', [JenisIdentitasController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_jenisidentitas'])
            ->name('buat-jenisidentitas');
        Route::post('/buat-jenisidentitas', [JenisIdentitasController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_jenisidentitas'])
            ->name('store-jenisidentitas');
        Route::get('/show-jenisidentitas/{id}', [JenisIdentitasController::class, 'show'])
            ->middleware(['boilerplateauth', 'ability:admin,show_jenisidentitas'])
            ->name('show-jenisidentitas');
        Route::get('/edit-jenisidentitas/{id}', [JenisIdentitasController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_jenisidentitas'])
            ->name('edit-jenisidentitas');
        Route::put('/edit-jenisidentitas/{id}', [JenisIdentitasController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_jenisidentitas'])
            ->name('update-jenisidentitas');
        Route::delete('/delete-jenisidentitas/{id}', [JenisIdentitasController::class, 'destroy'])
            ->middleware(['boilerplateauth', 'ability:admin,hapus_jenisidentitas'])
            ->name('delete-jenisidentitas');

        //jenis paket
        Route::get('/jenispaket', [JenisPaketController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,lihat_jenispaket'])
            ->name('jenispaket');
        Route::get('/buat-jenispaket', [JenisPaketController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_jenispaket'])
            ->name('buat-jenispaket');
        Route::post('/buat-jenispaket', [JenisPaketController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_jenispaket'])
            ->name('store-jenispaket');
        Route::get('/show-jenispaket/{id}', [JenisPaketController::class, 'show'])
            ->middleware(['boilerplateauth', 'ability:admin,show_jenispaket'])
            ->name('show-jenispaket');
        Route::get('/edit-jenispaket/{id}', [JenisPaketController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_jenispaket'])
            ->name('edit-jenispaket');
        Route::put('/edit-jenispaket/{id}', [JenisPaketController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_jenispaket'])
            ->name('update-jenispaket');
        Route::delete('/delete-jenispaket/{id}', [JenisPaketController::class, 'destroy'])
            ->middleware(['boilerplateauth', 'ability:admin,hapus_jenispaket'])
            ->name('delete-jenispaket');

        //pelanggan
        Route::get('/pelanggan', [PelangganController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,lihat_pelanggan'])
            ->name('pelanggan');
        Route::get('/buat-pelanggan', [PelangganController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pelanggan'])
            ->name('buat-pelanggan');
        Route::post('/buat-pelanggan', [PelangganController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_pelanggan'])
            ->name('store-pelanggan');
        Route::get('/show-pelanggan/{id}', [PelangganController::class, 'show'])
            ->middleware(['boilerplateauth', 'ability:admin,show_pelanggan'])
            ->name('show-pelanggan');
        Route::get('/edit-pelanggan/{id}', [PelangganController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_pelanggan'])
            ->name('edit-pelanggan');
        Route::put('/edit-pelanggan/{id}', [PelangganController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_pelanggan'])
            ->name('update-pelanggan');
        Route::delete('/delete-pelanggan/{id}', [PelangganController::class, 'destroy'])
            ->middleware(['boilerplateauth', 'ability:admin,hapus_pelanggan'])
            ->name('delete-pelanggan');

        //booking
        Route::get('/booking', [BookingController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,lihat_booking'])
            ->name('booking');
        Route::get('/buat-booking', [BookingController::class, 'create'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_booking'])
            ->name('buat-booking');
        Route::post('/buat-booking', [BookingController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_booking'])
            ->name('store-booking');
        Route::get('/show-booking/{id}', [BookingController::class, 'show'])
            ->middleware(['boilerplateauth', 'ability:admin,show_booking'])
            ->name('show-booking');
        Route::get('/edit-booking/{id}', [BookingController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_booking'])
            ->name('edit-booking');
        Route::put('/edit-booking/{id}', [BookingController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_booking'])
            ->name('update-booking');
        Route::delete('/delete-booking/{id}', [BookingController::class, 'destroy'])
            ->middleware(['boilerplateauth', 'ability:admin,hapus_booking'])
            ->name('delete-booking');
        Route::get('/batal-booking/{id}', [BookingController::class, 'batal'])
            ->middleware(['boilerplateauth', 'ability:admin,batal_booking'])
            ->name('batal-booking');

        //get booking ajax
        Route::get('/buat-booking/get-paket', [BookingController::class, 'get_paket'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_booking'])
            ->name('get-paket');
        Route::get('/buat-booking/get-pelanggans', [BookingController::class, 'get_pelanggans'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_booking'])
            ->name('get-pelanggans');
        Route::get('/buat-booking/get-pelanggan', [BookingController::class, 'get_pelanggan'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_booking'])
            ->name('get-pelanggan');
        Route::get('/buat-booking/get-detail-paket', [BookingController::class, 'get_detail_paket'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_booking'])
            ->name('get-detail-paket');
        Route::get('/buat-booking/get-mobils', [BookingController::class, 'get_mobils'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_booking'])
            ->name('get-mobils');
        Route::get('/buat-booking/gete-mobils', [BookingController::class, 'gete_mobils'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_booking'])
            ->name('gete-mobils');
        Route::get('/buat-booking/get-drivers', [BookingController::class, 'get_drivers'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_booking'])
            ->name('get-drivers');
        Route::get('/buat-booking/gete-drivers', [BookingController::class, 'gete_drivers'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_booking'])
            ->name('gete-drivers');

        //bayar booking
        Route::get('/cetak-tagihan/{id}.pdf', [BookingController::class, 'cetak_tagihan'])
            ->middleware(['boilerplateauth', 'ability:admin,cetak_tagihan'])
            ->name('cetak-tagihan');
        Route::get('/bayar-booking/{id}', [BookingController::class, 'bayar'])
            ->middleware(['boilerplateauth', 'ability:admin,bayar_booking'])
            ->name('bayar-booking');
        Route::post('/bayar-booking/{id}', [BookingController::class, 'store_bayar'])
            ->middleware(['boilerplateauth', 'ability:admin,bayar_booking'])
            ->name('store-bayar-booking');
        Route::get('/edit-bayar-booking/{id}', [BookingController::class, 'edit_bayar'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_bayar'])
            ->name('edit-bayar-booking');
        Route::put('/edit-bayar-booking/{id}', [BookingController::class, 'update_bayar'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_bayar'])
            ->name('update-bayar-booking');
        Route::delete('/delete-bayar-booking/{id}', [BookingController::class, 'delete_bayar'])
            ->middleware(['boilerplateauth', 'ability:admin,delete_bayar'])
            ->name('delete-bayar-booking');
        Route::get('/get-bukti-bayar/{id}.jpeg', [BookingController::class, 'get_bukti'])
            ->middleware(['boilerplateauth', 'ability:admin,show_booking'])
            ->name('get-bukti-bayar');
        Route::get('/get-tagihan', [BookingController::class, 'get_tagihan'])
            ->middleware(['boilerplateauth', 'ability:admin,show_booking'])
            ->name('get-tagihan');

        //proses booking
        Route::get('/proses-booking/{id}', [BookingController::class, 'proses'])
            ->middleware(['boilerplateauth', 'ability:admin,proses_booking'])
            ->name('proses-booking');
        Route::get('/selesai-booking/{id}', [BookingController::class, 'selesai'])
            ->middleware(['boilerplateauth', 'ability:admin,selesai_booking'])
            ->name('selesai-booking');

        //transaksi
        Route::get('/transaksi', [TransaksiController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,lihat_transaksi'])
            ->name('transaksi');
        Route::get('/show-transaksi/{id}', [TransaksiController::class, 'show'])
            ->middleware(['boilerplateauth', 'ability:admin,show_transaksi'])
            ->name('show-transaksi');
        Route::get('/edit-transaksi/{id}', [TransaksiController::class, 'edit'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_transaksi'])
            ->name('edit-transaksi');
        Route::put('/edit-transaksi/{id}', [TransaksiController::class, 'update'])
            ->middleware(['boilerplateauth', 'ability:admin,edit_transaksi'])
            ->name('update-transaksi');
        Route::delete('/delete-transaksi/{id}', [TransaksiController::class, 'destroy'])
            ->middleware(['boilerplateauth', 'ability:admin,hapus_transaksi'])
            ->name('delete-transaksi');

        //jadwal
        Route::get('/jadwal', [JadwalController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,lihat_jadwal'])
            ->name('jadwal');
        Route::get('/jadwal/get-jadwal', [JadwalController::class, 'get_jadwal'])
            ->middleware(['boilerplateauth', 'ability:admin,lihat_jadwal'])
            ->name('get-jadwal');
        Route::get('/jadwal/get-jadwal-mobil', [JadwalController::class, 'get_jadwal_mobil'])
            ->middleware(['boilerplateauth', 'ability:admin,lihat_jadwal'])
            ->name('get-jadwal-mobil');

        //tagihan
        Route::get('/buat-tagihan/{id}', [TagihanController::class, 'store'])
            ->middleware(['boilerplateauth', 'ability:admin,buat_tagihan'])
            ->name('store-tagihan');

        //tagihan
        Route::get('/audit-trail', [ActivityLogController::class, 'index'])
            ->middleware(['boilerplateauth', 'ability:admin,logs'])
            ->name('audit-trail');
    });
});
