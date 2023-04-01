<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\FaceUploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


Route::middleware('verified')->group(function () {
    // 共通
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // 一般ユーザ用
    Route::prefix('user')->group(function () {
        // Route::get('/', 'User\HomeController@index');
        // Route::resource('entryForms', App\Http\Controllers\entryFormController::class);
        // Route::resource('elearnings', App\Http\Controllers\elearningController::class);
        // Route::resource('resultUploads', App\Http\Controllers\resultUploadController::class);
        // Route::resource('planUploads', App\Http\Controllers\planUploadController::class, ['except' => ['edit','show','update']]);
        // Route::resource('temps', App\Http\Controllers\tempsController::class);
        // Route::resource('resultInputs', App\Http\Controllers\resultInputsController::class);
        Route::resource('entryInfos', App\Http\Controllers\Entry_infoController::class);
        Route::get('/pdf', [App\Http\Controllers\Entry_infoController::class, 'pdf'])->name('pdf');
        Route::resource('upload',UploadController::class);
        Route::resource('face_upload',FaceUploadController::class);
        Route::get('/delete_file', [App\Http\Controllers\Entry_infoController::class, 'delete_file'])->name('delete_file'); // ファイルの削除
    });
    // 管理ユーザ用
    Route::prefix('admin')->middleware('can:admin')->group(function () {
        Route::resource('admin_entryInfos', App\Http\Controllers\AdminEntry_infoController::class);
        Route::get('/pdf', [App\Http\Controllers\AdminEntry_infoController::class, 'pdf'])->name('pdf');
        Route::get('/ais_check', [App\Http\Controllers\AdminEntry_infoController::class, 'ais_check'])->name('ais_check');
        Route::get('/admin_export', [App\Http\Controllers\AdminEntry_infoController::class, 'admin_export'])->name('admin_export');
        // Route::get('/', 'Admin\HomeController@index');
        // Route::resource('adminConfigs', App\Http\Controllers\AdminConfigController::class);
        // Route::resource('adminentries', App\Http\Controllers\adminentryFormController::class, ['except' => 'create']);
        // Route::get('non_tokyo', [App\Http\Controllers\adminentryFormController::class, 'non_tokyo'])->name('non_tokyo');
        // Route::get('/deleted', [App\Http\Controllers\adminentryFormController::class, 'deleted'])->name('deleted');
        // Route::resource('buddylists', App\Http\Controllers\BuddylistController::class);
        // Route::get('fee_check', [App\Http\Controllers\adminentryFormController::class, 'fee_check'])->name('fee_check');
        // Route::get('registration_check', [App\Http\Controllers\adminentryFormController::class, 'registration_check'])->name('registration_check');
        // Route::resource('adminresultUploads', App\Http\Controllers\adminresultUploadController::class, ['except' => 'create']);
        // Route::get('/result_lists', [App\Http\Controllers\adminresultUploadController::class, 'lists'])->name('resultlists');
        // Route::get('/temp_lists', [App\Http\Controllers\tempsController::class, 'temp_list'])->name('templists');
        // Route::resource('reach50100', App\Http\Controllers\reach50100Controller::class);
        // Route::resource('adminplanUploads', App\Http\Controllers\adminplanUploadController::class, ['except' => ['create','edit','show','update']]);
    });
    // スタッフ用
    // Route::prefix('staff')->middleware('can:staff')->group(function () {
    //     Route::resource('staffplanUploads', App\Http\Controllers\staffplanUploadController::class, ['except' => ['create','edit','show','update']]);
    // });
    // 地区コミ用
    Route::prefix('commi')->middleware('can:commi')->group(function () {
        Route::resource('commi_entryInfos', App\Http\Controllers\CommiEntry_infoController::class);
        Route::get('/pdf', [App\Http\Controllers\CommiEntry_infoController::class, 'pdf'])->name('pdf');
        Route::get('/commi_check', [App\Http\Controllers\CommiEntry_infoController::class, 'commi_check'])->name('commi_check');
        // Route::resource('entries', App\Http\Controllers\commiEntryFormController::class, ['only' => ['index', 'show']]);
        // Route::get('commi_check', [App\Http\Controllers\commiEntryFormController::class, 'commi_check'])->name('commi_check');
    });
});
