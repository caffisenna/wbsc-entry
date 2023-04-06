<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry_info;
use Flash;

class ConfirmController extends Controller
{
    public function trainer_confirm(Request $request)
    {
        // 参加者データを拾って認定画面にリダイレクト
        $uuid = $request['uuid'];
        $userinfo = Entry_info::where('uuid', $uuid)->with('user')->firstOrFail();
        return view('confirm.trainer')->with('userinfo', $userinfo);
    }

    public function trainer_confirm_post(Request $request)
    {
        // 認定ボタンが押されたときの処理
        $uuid = $request['uuid'];
        $userinfo = Entry_info::where('uuid', $uuid)->with('user')->firstOrFail();

        $name_sc = $request['name_sc'];
        $confirm_date_sc = $request['confirm_date_sc'];
        $name_division = $request['name_division'];
        $confirm_date_division = $request['confirm_date_division'];

        if (isset($name_sc) && isset($confirm_date_sc)) {
            // SCのセット
            $userinfo->trainer_sc_checked_at = $confirm_date_sc;
            $userinfo->trainer_sc_name = $name_sc;
            $userinfo->save();
            Flash::success($userinfo->user->name . 'さんのスカウトコース課題研修についてトレーナー認定を行いました');
        } elseif (isset($name_division) && isset($confirm_date_division)) {
            // 課程別のセット
            $userinfo->trainer_division_checked_at = $confirm_date_division;
            $userinfo->trainer_division_name = $name_division;
            $userinfo->save();
            Flash::success($userinfo->user->name . 'さんの課程別課題研修についてトレーナー認定を行いました');
        }

        // 前画面に戻る
        return back();
    }
}
