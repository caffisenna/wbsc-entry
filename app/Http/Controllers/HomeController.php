<?php

namespace App\Http\Controllers;

use App\Models\Entry_info;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->is_admin) {
            // 管理者
            // 各コースの申込人数を集計してhome画面に渡す
            if (Auth::user()->is_ais) { // 地区AIS委員用 地区名がis_aisにあればフィルタをかける
                $count = Entry_info::where('district', Auth::user()->is_ais)->select('sc_number')->selectRaw('count(user_id) as count_sc_number')->groupBy('sc_number')->get();
            } else {
                $count = Entry_info::select('sc_number')->selectRaw('count(user_id) as count_sc_number')->groupBy('sc_number')->get();
            }
            $count = $count->sortBy('sc_number'); // 期数毎にソート

            if (Auth::user()->is_ais) {
                $div_count = Entry_info::select('division_number')->where('district', Auth::user()->is_ais)->selectRaw('count(user_id) as count_division_number')->groupBy('division_number')->get();
            } else {
                $div_count = Entry_info::select('division_number')->selectRaw('count(user_id) as count_division_number')->groupBy('division_number')->get();
            }
            $div_count = $div_count->sortBy('division_number'); // 回数毎にソート

            if (Auth::user()->is_ais) {
                $danken_count = Entry_info::where('danken', '<>', NULL)->select('danken')->where('district', Auth::user()->is_ais)->selectRaw('count(user_id) as count_danken')->groupBy('danken')->get();
            } else {
                $danken_count = Entry_info::where('danken', '<>', NULL)->select('danken')->selectRaw('count(user_id) as count_danken')->groupBy('danken')->get();
            }
            // $danken_count = $danken_count; // 団研の人数カウント

            // return view('home')->with('count', $count)->with('div_count', $div_count)->with('danken_count', $danken_count);
            return view('home', compact('count', 'div_count', 'danken_count'));
        } elseif (Auth::user()->is_course_staff) {
            // コーススタッフ
            return redirect()->route('course_staff.index');
        } elseif (Auth::user()->is_commi) {
            // 地区コミ
            // 地区の一覧にリダイレクト
            return redirect()->route('commi_entryInfos.index');
        } else {
            // 一般ユーザーがログインしたときに、申込情報にリダイレクト
            return redirect(route('entryInfos.index'));
        }
    }
}
