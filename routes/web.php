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

Route::get('/about', function () {
    return view('about');
});

// トレーナー認定
Route::get('/confirm/trainer', [App\Http\Controllers\ConfirmController::class, 'trainer_confirm'])->name('trainer_confirm');
Route::post('/confirm/trainer', [App\Http\Controllers\ConfirmController::class, 'trainer_confirm_post'])->name('trainer_confirm_post');

// 団委員長承認
Route::get('/confirm/gm', [App\Http\Controllers\ConfirmController::class, 'gm_confirm'])->name('gm_confirm');
Route::post('/confirm/gm', [App\Http\Controllers\ConfirmController::class, 'gm_confirm_post'])->name('gm_confirm_post');

// 使い方ガイド
Route::get('/howto_gm', function () {
    return view('howto_gm');        // 団委員長
});

Route::get('/howto_trainer', function () {
    return view('howto_trainer');   // トレーナー
});
Route::get('/howto_commi', function () {
    return view('howto_commi');     // 地区コミ
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
        Route::resource('entryInfos', App\Http\Controllers\Entry_infoController::class);
        Route::get('/pdf', [App\Http\Controllers\Entry_infoController::class, 'pdf'])->name('pdf');
        Route::resource('upload', UploadController::class);
        Route::resource('face_upload', FaceUploadController::class);
        Route::get('/delete_file', [App\Http\Controllers\Entry_infoController::class, 'delete_file'])->name('delete_file'); // ファイルの削除
    });
    // 管理ユーザ用
    Route::prefix('admin')->middleware('can:admin')->group(function () {
        Route::resource('admin_entryInfos', App\Http\Controllers\AdminEntry_infoController::class);
        Route::get('/pdf', [App\Http\Controllers\AdminEntry_infoController::class, 'pdf'])->name('admin_pdf');
        Route::get('/multi_pdf', [App\Http\Controllers\AdminEntry_infoController::class, 'multi_pdf'])->name('multi_pdf');
        Route::get('/ais_check', [App\Http\Controllers\AdminEntry_infoController::class, 'ais_check'])->name('ais_check');
        Route::get('/admin_export', [App\Http\Controllers\AdminEntry_infoController::class, 'admin_export'])->name('admin_export');
        Route::get('/fee_check', [App\Http\Controllers\AdminEntry_infoController::class, 'fee_check'])->name('fee_check');
        Route::get('/revert', [App\Http\Controllers\AdminEntry_infoController::class, 'revert'])->name('revert'); // 取り消し
        Route::get('/accept', [App\Http\Controllers\AdminEntry_infoController::class, 'accept'])->name('accept'); // 参加承認
        Route::get('/certificate', [App\Http\Controllers\AdminEntry_infoController::class, 'certificate'])->name('certificate'); // 修了認定
        Route::resource('courseLists', App\Http\Controllers\course_listController::class); // スカウトコース設定
        Route::resource('divisionLists', App\Http\Controllers\division_listController::class); // 課程別研修設定
        Route::match(['get','post'],'/add_users/password_reset', [App\Http\Controllers\add_userController::class, 'pass_reset'])->name('pass_reset'); // passwordリセット
        Route::resource('add_users', App\Http\Controllers\add_userController::class); // ユーザー追加
    });

    // 地区コミ用
    Route::prefix('commi')->middleware('can:commi,admin')->group(function () {
        Route::resource('commi_entryInfos', App\Http\Controllers\CommiEntry_infoController::class);
        Route::get('/pdf', [App\Http\Controllers\CommiEntry_infoController::class, 'pdf'])->name('commi_pdf');
        Route::get('/commi_check', [App\Http\Controllers\CommiEntry_infoController::class, 'commi_check'])->name('commi_check');
        Route::get('/trainer_request', [App\Http\Controllers\CommiEntry_infoController::class, 'trainer_request'])->name('trainer_request');
        Route::post('/trainer_request_send', [App\Http\Controllers\CommiEntry_infoController::class, 'trainer_request_send'])->name('trainer_request_send');
        Route::get('/gm_request', [App\Http\Controllers\CommiEntry_infoController::class, 'gm_request'])->name('gm_request');
        Route::post('/gm_request_send', [App\Http\Controllers\CommiEntry_infoController::class, 'gm_request_send'])->name('gm_request_send');
        Route::get('/commi_comment', [App\Http\Controllers\CommiEntry_infoController::class, 'commi_comment'])->name('commi_comment'); // 副申請書
        Route::post('/commi_comment', [App\Http\Controllers\CommiEntry_infoController::class, 'commi_comment_post'])->name('commi_comment_post'); // 副申請書
        // 以下2行 地区内優先順位ソート
        Route::get('/priority', [App\Http\Controllers\CommiEntry_infoController::class, 'priority'])->name('priority');
        Route::post('/priority_sortable', [App\Http\Controllers\CommiEntry_infoController::class, 'priority_sortable'])->name('priority_sortable');
    });
});
