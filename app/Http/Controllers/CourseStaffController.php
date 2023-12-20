<?php

namespace App\Http\Controllers;

use App\Repositories\Entry_infoRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Entry_info;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use App\Models\User;
use Carbon\Carbon;

class CourseStaffController extends AppBaseController
{
    /** @var Entry_infoRepository $entryInfoRepository*/
    private $entryInfoRepository;

    public function __construct(Entry_infoRepository $entryInfoRepo)
    {
        $this->entryInfoRepository = $entryInfoRepo;
    }

    /**
     * Display a listing of the Entry_info.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // ユーザー認証区分を取得
        $user = Auth::user();
        $q = $user->is_course_staff;

        $entryInfos = User::whereHas('entry_info', function ($query) use ($q) {
            if (substr($q, 0, 2) === 'SC') {
                // $qの先頭2文字がSCならスカウトコース
                $q = preg_replace("/[^0-9]/", "", $q);
                $query->where('sc_number', $q);
            } elseif ($q == '団研') {
                // 団研
                $query->whereNotNull('danken');
            } else {
                // それ以外 = 課程別
                $query->where('division_number', $q);
            }
        })->with(['entry_info' => function ($query) {
            $query->orderBy('order', 'asc');
        }])->get();

        // 平均年齢計算
        function calculateAge($birthdate)
        {
            return Carbon::parse($birthdate)->age;
        }

        // 年齢を配列に変換
        $ages = $entryInfos->pluck('entry_info.birthday')->map(function ($birthdate) {
            return calculateAge($birthdate);
        });

        // 平均年齢を計算
        $averageAge = $ages->average();
        // 平均年齢計算

        // 男女別の個数を取得
        $genderCounts = $entryInfos->groupBy('entry_info.gender')->map(function ($group) {
            return $group->count();
        });

        // troop別の個数を取得
        $troopCounts = $entryInfos->groupBy('entry_info.troop')->map(function ($group) {
            return $group->count();
        });

        return view('course_staff.index', compact(['entryInfos', 'averageAge', 'genderCounts','troopCounts']));
    }

    /**
     * Display the specified Entry_info.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        // $entryInfo = User::where('id', $id)->with('entry_info')->first();
        $entryInfo = Entry_info::where('uuid', $id)->with('user')->first();

        if (empty($entryInfo)) {
            Flash::error('対象が見つかりません');

            return redirect(route('course_staff.index'));
        }

        return view('course_staff.show')->with('entryInfo', $entryInfo);
    }

    public function pdf(Request $request)
    {
        $id = $request['id'];
        $entryInfo = User::where('id', $id)->with('entry_info')->first();

        $pdf = \PDF::loadView('entry_infos.pdf', compact('entryInfo'));
        $filename = 'WB研修所・課程別研修申込書 ' . $entryInfo->entry_info->district . ' ' . $entryInfo->name . '.pdf';
        // $pdf->setPaper('A4');
        return $pdf->download($filename);
        // return $pdf->stream();
    }
}
