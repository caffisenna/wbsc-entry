<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\FaceUploadController;
use App\Http\Controllers\AdminEntry_infoController;
use App\Http\Controllers\add_userController;
use App\Http\Controllers\course_listController;
use App\Http\Controllers\division_listController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\Entry_infoController;
use App\Http\Controllers\CommiEntry_infoController;
use App\Http\Controllers\CourseStaffController;

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
Route::get('/confirm/trainer', [ConfirmController::class, 'trainer_confirm'])->name('trainer_confirm');
Route::post('/confirm/trainer', [ConfirmController::class, 'trainer_confirm_post'])->name('trainer_confirm_post');

// 団委員長承認
Route::get('/confirm/gm', [ConfirmController::class, 'gm_confirm'])->name('gm_confirm');
Route::post('/confirm/gm', [ConfirmController::class, 'gm_confirm_post'])->name('gm_confirm_post');

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
        Route::resource('entryInfos', Entry_infoController::class);
        Route::get('/pdf', [Entry_infoController::class, 'pdf'])->name('pdf');
        Route::resource('upload', UploadController::class);
        Route::resource('face_upload', FaceUploadController::class);
        Route::get('/delete_file', [Entry_infoController::class, 'delete_file'])->name('delete_file'); // ファイルの削除
    });
    // 管理ユーザ用
    Route::prefix('admin')->middleware('can:admin')->group(function () {
        Route::resource('admin_entryInfos', AdminEntry_infoController::class);
        Route::get('/pdf', [AdminEntry_infoController::class, 'pdf'])->name('admin_pdf');
        Route::get('/multi_pdf', [AdminEntry_infoController::class, 'multi_pdf'])->name('multi_pdf');
        Route::get('/ais_check', [AdminEntry_infoController::class, 'ais_check'])->name('ais_check');
        Route::get('/admin_export', [AdminEntry_infoController::class, 'admin_export'])->name('admin_export');
        Route::get('/certificate_export', [AdminEntry_infoController::class, 'certificate_export'])->name('certificate_export');
        Route::get('/fee_check', [AdminEntry_infoController::class, 'fee_check'])->name('fee_check');
        Route::get('/revert', [AdminEntry_infoController::class, 'revert'])->name('revert'); // 取り消し
        Route::get('/accept', [AdminEntry_infoController::class, 'accept'])->name('accept'); // 参加承認
        Route::get('/certificate', [AdminEntry_infoController::class, 'certificate'])->name('certificate'); // 修了認定
        Route::resource('courseLists', course_listController::class); // スカウトコース設定
        Route::resource('divisionLists', division_listController::class); // 課程別研修設定
        Route::match(['get', 'post'], '/add_users/password_reset', [add_userController::class, 'pass_reset'])->name('pass_reset'); // passwordリセット
        Route::resource('add_users', add_userController::class); // ユーザー追加
        Route::get('/email_not_verified', [AdminEntry_infoController::class, 'email_not_verified'])->name('email_not_verified'); // メール未認証
        Route::get('/health_memo', [AdminEntry_infoController::class, 'health_memo'])->name('health_memo'); // 健康上の特記事項
        Route::post('/save_user_memo', [AdminEntry_infoController::class, 'save_user_memo'])->name('save_user_memo'); // 未認証者のメモ
        Route::resource('dankenLists', App\Http\Controllers\DankenListsController::class);
        Route::get('/sendReminderEmailForFee', [AdminEntry_infoController::class, 'sendReminderEmailForFee'])->name('sendReminderEmailForFee'); // 督促メール
        Route::get('/resetFeeCheckDate', [AdminEntry_infoController::class, 'resetFeeCheckDate'])->name('resetFeeCheckDate'); // 入金日リセット
    });

    // 地区コミ用
    Route::prefix('commi')->middleware('can:commi,admin')->group(function () {
        Route::resource('commi_entryInfos', CommiEntry_infoController::class);
        Route::get('/pdf', [CommiEntry_infoController::class, 'pdf'])->name('commi_pdf');
        Route::get('/commi_check', [CommiEntry_infoController::class, 'commi_check'])->name('commi_check');
        Route::get('/trainer_request', [CommiEntry_infoController::class, 'trainer_request'])->name('trainer_request');
        Route::post('/trainer_request_send', [CommiEntry_infoController::class, 'trainer_request_send'])->name('trainer_request_send');
        Route::get('/gm_request', [CommiEntry_infoController::class, 'gm_request'])->name('gm_request');
        Route::post('/gm_request_send', [CommiEntry_infoController::class, 'gm_request_send'])->name('gm_request_send');
        Route::get('/commi_comment', [CommiEntry_infoController::class, 'commi_comment'])->name('commi_comment'); // 副申請書
        Route::post('/commi_comment', [CommiEntry_infoController::class, 'commi_comment_post'])->name('commi_comment_post'); // 副申請書
        // 以下2行 地区内優先順位ソート
        Route::get('/priority', [CommiEntry_infoController::class, 'priority'])->name('priority');
        Route::post('/priority_sortable', [CommiEntry_infoController::class, 'priority_sortable'])->name('priority_sortable');
    });

    // コーススタッフ用
    Route::prefix('course_staff')->middleware('can:course_staff')->group(function () {
        Route::resource('course_staff', CourseStaffController::class);
        Route::get('/export', [CourseStaffController::class, 'export'])->name('course_staff_export');
        Route::get('/pdf', [CourseStaffController::class, 'pdf']);
    });
});
