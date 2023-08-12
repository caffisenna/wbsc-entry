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
use App\Http\Util\Slack\SlackPost;
use Illuminate\Support\Facades\Log;

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

        // 画像のリサイズ 横幅600pxに
        $file = \Image::make($file)->orientate()->resize(
            600,
            null,
            function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            }
        );
        // $extension = $file->extension();

        // ユーザーテーブルにファイル名を保存
        $user = User::where('id', Auth::id())->with('entry_info')->first(); // DB取得
        $user->face_picture = $name;
        $user->save();

        $path = 'picture'; // 画像保存先

        // ファイル保存
        $file->save(public_path('/storage/' . $path . '/' . $name));

        // 氏名と地区を取得
        $name = $user->name;
        $dist = $user->entry_info->district;

        // ローカル環境ではslackに通知しない
        if (config('app.env') !== 'local') {
            $slack = new SlackPost();
            $slack->send(":frame_with_picture:" . $dist . '地区 ' . $name . 'さんが 顔写真をアップロードしました');
        }

        // logging
        Log::channel('user_action')->info($dist . '地区 ' . $name . 'さんが 顔写真をアップロードしました');

        // flashメッセージを返す
        Flash::success('顔写真をアップロードしました');

        // リダイレクト
        return redirect()->route('entryInfos.index');
    }
}
