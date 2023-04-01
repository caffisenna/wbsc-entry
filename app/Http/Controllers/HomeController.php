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
            // 各コースの申込人数を集計してhome画面に渡す
            $count = Entry_info::select('sc_number')->selectRaw('count(user_id) as count_sc_number')->groupBy('sc_number')->get();
            $count = $count->sortBy('sc_number'); // 期数毎にソート
            $div_count = Entry_info::select('division_number')->selectRaw('count(user_id) as count_division_number')->groupBy('division_number')->get();
            $div_count = $div_count->sortBy('division_number'); // 回数毎にソート

            return view('home')->with('count', $count)->with('div_count', $div_count);
        } else {
            return view('home');
        }
    }
}
