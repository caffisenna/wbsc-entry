<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry_info;
use Flash;
use App\Mail\GmConfirm;
use Mail;
use App\Mail\TrainerConfirm;
use App\Http\Util\SlackPost;
use App\Models\GmAddress;

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
        $name_danken = $request['name_danken'];
        $confirm_date_danken = $request['confirm_date_danken'];

        // slack通知
        // disable slack notification from local
        if (config('app.env') !== 'local') {
            $slack = new SlackPost();

            if (isset($name_sc) && isset($confirm_date_sc)) {
                // SCのセット
                $userinfo->trainer_sc_checked_at = $confirm_date_sc;
                $userinfo->trainer_sc_name = $name_sc;
                $userinfo->save();
                Flash::success($userinfo->user->name . 'さんのスカウトコース課題研修についてトレーナー認定を行いました');
                $slack->send(':white_check_mark:' . $userinfo->district . '地区 ' . $userinfo->user->name . ' さんのスカウトコース課題についてトレーナー認定完了');
            } elseif (isset($name_division) && isset($confirm_date_division)) {
                // 課程別のセット
                $userinfo->trainer_division_checked_at = $confirm_date_division;
                $userinfo->trainer_division_name = $name_division;
                $userinfo->save();
                Flash::success($userinfo->user->name . 'さんの課程別課題研修についてトレーナー認定を行いました');
                $slack->send(':white_check_mark:' . $userinfo->district . '地区 ' . $userinfo->user->name . ' さんの課程別研修課題についてトレーナー認定完了');
            } elseif (isset($name_danken) && isset($confirm_date_danken)) {
                // 課程別のセット
                $userinfo->trainer_danken_checked_at = $confirm_date_danken;
                $userinfo->trainer_danken_name = $name_danken;
                $userinfo->save();
                Flash::success($userinfo->user->name . 'さんの課程別課題研修についてトレーナー認定を行いました');
                $slack->send(':white_check_mark:' . $userinfo->district . '地区 ' . $userinfo->user->name . ' さんの課程別研修課題についてトレーナー認定完了');
            }
        }

        // 確認メール送信
        $sendto = $userinfo->user->email;
        $name = $userinfo->user->name;
        Mail::to($sendto)->queue(new TrainerConfirm($name, $uuid)); // メールをqueueで送信

        // 前画面に戻る
        return back();
    }

    public function gm_confirm(Request $request)
    {
        // 参加者データを拾って認定画面にリダイレクト
        $uuid = $request['uuid'];
        $userinfo = Entry_info::where('uuid', $uuid)->with('user')->firstOrFail();
        return view('confirm.gm')->with('userinfo', $userinfo);
    }

    public function gm_confirm_post(Request $request)
    {
        // 承認ボタンが押されたときの処理
        $uuid = $request['uuid'];
        $userinfo = Entry_info::where('uuid', $uuid)->with('user')->firstOrFail();

        $gm_name = $request['gm_name'];
        $gm_checked_at = $request['gm_checked_at'];
        $gm_email = $request['gm_email'];
        // dd($gm_email);

        if (isset($gm_name) && isset($gm_checked_at)) {
            $userinfo->gm_checked_at = $gm_checked_at;
            $userinfo->gm_name = $gm_name;
            $userinfo->save();

            // 確認メール送信
            $sendto = $userinfo->user->email;
            $name = $userinfo->user->name;
            Mail::to($sendto)->queue(new GmConfirm($uuid, $name)); // メールをqueueで送信
            Flash::success($userinfo->user->name . 'さんの参加承認を行いました');

            // slack通知
            // disable slack notification form local
            if (config('app.env') !== 'local') {
                $slack = new SlackPost();
                $slack->send(':white_check_mark:' . $userinfo->district . '地区 ' . $userinfo->user->name . ' さんの団承認が完了しました');
            }

            // 団委員長のメアド登録
            if ($gm_email !== null) {
                GmAddress::create([
                    'uuid' => $uuid,
                    'name' => $name,
                    'email' => $gm_email,
                ]);
            }
        }

        // 前画面に戻る
        return back();
    }
}
