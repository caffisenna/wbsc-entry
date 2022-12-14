<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entry_info;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FaceUploadController extends Controller
{
    public function index(Request $request)
    {
        return view('face_upload.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:jpg,jpeg,png,gif',
        ];

        $messages = [
            'file.required' => 'ファイルをアップロードしてください',
            'file.mimes' => 'ファイルは画像形式(jpg,jpeg,png,gif)のみです',
        ];

        $validator = validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // 申込書IDからUUIDを引っ張るのが必要!!
        // $uuid = $request['uuid'];
        $file = $request->file('file');
        $name = $file->hashName();
        // $extension = $file->extension();

        // ユーザーテーブルにファイル名を保存
        $user = User::where('id', Auth::id())->first(); // DB取得
        $user->face_picture = $name;
        $user->save();

        $path = 'public/picture'; // 画像保存先

        // ファイル保存
        $request->file('file')->storeAs($path, $name);

        // flashメッセージを返す
        Flash::success('顔写真をアップロードしました');

        // リダイレクト
        return back();
    }
}
