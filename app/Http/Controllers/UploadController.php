<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entry_info;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        // んー、申込書に紐付いた形でアップされないと、引っ張れない。
        // 申込書のUUIDと関連付ける方法が必要
        $q = $request['q'];
        $uuid = $request['uuid'];
        // dd($uuid);
        // スカウトコースは q=sc
        // 課程別は q=division で受ける

        return view('upload.index')->with('uuid', $uuid)->with('q', $q);
    }

    public function store(Request $request)
    {
        // 申込書IDからUUIDを引っ張るのが必要!!
        $uuid = $request['uuid'];
        $q = $request['q'];
        $file = $request->file('file');
        // $name = $file->hashName();
        $extension = $file->extension();

        // SCと課程別で保存先を変える
        $entryinfo = Entry_info::where('uuid', $uuid)->first(); // DB取得
        if ($q == 'sc') {
            $path = 'public/assignment/sc';
            $entryinfo->assignment_sc = 'up';
        } elseif ($q == 'division') {
            $path = 'public/assignment/division';
            $entryinfo->assignment_division = 'up';
        }
        $entryinfo->save();

        // ファイル保存
        $request->file('file')->storeAs($path, $uuid . '.' . $extension);

        // flashメッセージを返す
        Flash::success('課題研修をアップロードしました');

        // リダイレクト
        return back();
    }
}
