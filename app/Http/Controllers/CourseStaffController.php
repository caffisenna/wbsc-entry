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
use App\Exports\ExcelExport; // excel export用
use Maatwebsite\Excel\Facades\Excel; // excel export用

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
        }])
            ->with('health_info') // 健康情報取得
            ->get();

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
        $averageAge = number_format($averageAge, 2);
        // 平均年齢計算

        // 男女別の個数を取得
        $genderCounts = $entryInfos->groupBy('entry_info.gender')->map(function ($group) {
            return $group->count();
        });

        // troop別の個数を取得
        $troopCounts = $entryInfos->groupBy('entry_info.troop')->map(function ($group) {
            return $group->count();
        });

        return view('course_staff.index', compact(['entryInfos', 'averageAge', 'genderCounts', 'troopCounts']));
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
        $entryInfo = Entry_info::where('uuid', $id)->with(['user', 'health_info'])->first();

        if (empty($entryInfo)) {
            Flash::error('対象が見つかりません');

            return redirect(route('course_staff.index'));
        }

        return view('course_staff.show', compact(['entryInfo']));
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

    public function export(Request $request)
    {
        $q = Auth::user()->is_course_staff; // どのコース権限か

        // 課程と回数を分離
        preg_match('/([A-Za-z]+)([0-9]+)/', $q, $matches);
        // アルファベットと数字をそれぞれ変数に格納
        @$alphabetPart = $matches[1];
        @$numberPart = $matches[2];

        // 分割したパートでどのコースか判定
        if ($alphabetPart == 'SC') {
            // スカウトコース
            $data = Entry_info::with('user')->where('sc_number', $numberPart)->get();
        } elseif ($q == '団研') {
            // 団研
            $data = Entry_info::with('user')->whereNotNull('danken')->get();
        } else {
            // 課程別研修
            $data = Entry_info::with('user')->where('division_number', $q)->get();
        }


        // DLファイル名の指定
        if ($alphabetPart == 'SC') {
            $filename = 'スカウトコース申込一覧 ' . $q . '期.xlsx';
        } elseif ($q == '団研') {
            $filename = '団研申込一覧.xlsx';
        } else {
            $filename = '課程別研修申込一覧 ' . $q . '回.xlsx';
        }

        //エクセルの見出しを以下で設定
        if ($q == '団研') {
            $headings = [
                '申込ID',
                '団研期数',
                '県連',
                '地区',
                '団名',
                '隊',
                '役務',
                '氏名',
                'ふりがな',
                'ケータイ',
                'email',
                '性別',
                '生年月日',
                '年齢',
                'BS講習会',
                'スカキャン',
                '研修歴(研)',
                '研修歴(実)',
                '奉仕歴',
                '現在治療中の病気',
                '直近3ヶ月の健康状態',
                '最近の体調',
                '医師からの注意',
                '特記事項・過去の傷病等',
                '食物アレルギー',
                'アレルゲン',
                'アレルゲンを摂取するとどうなるか',
                'アレルゲンに対する家庭での対応',
            ];
        } else {
            $headings = [
                '申込ID',
                'SC期数',
                '課程別回数',
                '県連',
                '地区',
                '団名',
                '隊',
                '役務',
                '氏名',
                'ふりがな',
                'ケータイ',
                'email',
                '性別',
                '生年月日',
                '年齢',
                'BS講習会',
                'スカキャン',
                '研修歴(研)',
                '研修歴(実)',
                '奉仕歴',
                '現在治療中の病気',
                '直近3ヶ月の健康状態',
                '最近の体調',
                '医師からの注意',
                '特記事項・過去の傷病等',
                '食物アレルギー',
                'アレルゲン',
                'アレルゲンを摂取するとどうなるか',
                'アレルゲンに対する家庭での対応',
            ];
        }

        //以下で先ほど作成したExcelExportにデータを渡す。
        return Excel::download(new ExcelExport($data, $headings), $filename);
    }

    public function cancel(Request $request)
    {
        if ($request->isMethod('get')) {
            // getの時はページ遷移
            $uuid = $request['uuid'];
            $entryInfo = Entry_info::where('uuid', $uuid)->with('user')->firstOrFail();

            return view('course_staff.cancel')->with(compact('entryInfo'));
        } elseif ($request->isMethod('post')) {
            // postの時はDB更新処理

            // ユーザーを取得
            $user = Entry_info::where('uuid', $request['uuid'])->with('user')->firstOrFail();

            // 値をセット
            if (isset($request['cancel_sc'])) {
                $user->cancel = $request['cancel_sc'];
            }

            if (isset($request['cancel_div'])) {
                $user->cancel_div = $request['cancel_div'];
            }

            // DB保存
            $user->save();

            // flash
            $name = $user->user->name;
            Flash::success($name . 'さんのキャンセル情報を登録しました');

            return back();
        }
    }
}
