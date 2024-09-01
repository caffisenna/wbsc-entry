<?php

namespace App\Http\Controllers;

use App\Exports\CertificateExport;
use App\Http\Requests\CreateEntry_infoRequest;
use App\Http\Requests\UpdateEntry_infoRequest;
use App\Repositories\Entry_infoRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Entry_info;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AisChecked;
use App\Mail\sendReminderEmailForFee;
use App\Mail\resetNoticeEmailForFee;
use Illuminate\Support\Facades\DB; // excel export用
use App\Exports\ExcelExport; // excel export用
use Maatwebsite\Excel\Facades\Excel; // excel export用
use ZipArchive; // zipで固める
use Storage;
use App\Mail\FeeChecked;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Http\Util\SlackPost;
use App\Mail\AisAccepted;
use Illuminate\Support\Facades\Log;
use App\Models\course_list;
use App\Models\DankenLists;
use App\Models\division_list;
use App\Models\GmAddress;
use App\Models\HealthInfo;
use Maatwebsite\Excel\Imports\EndRowFinder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminEntry_infoController extends AppBaseController
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
        $districtOrder = [
            '大都心',
            'さくら',
            '城東',
            '山手',
            'つばさ',
            '世田谷',
            'あすなろ',
            '城北',
            '練馬',
            '多摩西',
            '新多磨',
            '南武蔵野',
            '町田',
            '北多摩'
        ];
        if (isset($request['q'])) { // スカウトコース 期数抽出
            if (Auth::user()->is_ais) {
                // 地区AIS委員
                $entryInfos = Entry_info::where('sc_number', $_REQUEST['q'])->where('district', Auth::user()->is_ais)->with('user')->get();
            } else {
                // 管理者
                $entryInfos = Entry_info::where('sc_number', $_REQUEST['q'])->with('user')->get();
            }
        } elseif (isset($request['div'])) { // 課程別研修 回数抽出
            if (Auth::user()->is_ais) {
                // 地区AIS委員
                $entryInfos = Entry_info::where('division_number', $_REQUEST['div'])->where('district', Auth::user()->is_ais)->with('user')->get();
            } else {
                // 管理者
                $entryInfos = Entry_info::where('division_number', $_REQUEST['div'])->with('user')->get();
            }
        } elseif (isset($request['danken'])) { // 団研抽出
            if (Auth::user()->is_ais) {
                // 地区AIS委員
                $entryInfos = Entry_info::whereNotNull('danken')->where('district', Auth::user()->is_ais)->with('user')->get();
            } else {
                // 管理者
                $entryInfos = Entry_info::whereNotNull('danken')->with('user')->get();
            }
        } else {
            if (Auth::user()->is_ais) {
                // 地区AIS委員
                $entryInfos = Entry_info::where('district', Auth::user()->is_ais)->with('user')->get();
            } else {
                // 管理者
                $entryInfos = Entry_info::with('user')->get();
            }
        }

        if ($request['q']) {
            $request['cat'] = 'sc';
            $course_info = course_list::where('number', $request['q'])->first();
        } elseif ($request['div']) {
            if ($request['div'] !== 'etc') {
                $request['cat'] = 'div';

                // 課程と回数を分離
                preg_match('/([A-Za-z]+)([0-9]+)/', $request['div'], $matches);

                // アルファベットと数字をそれぞれ変数に格納
                $alphabetPart = $matches[1];
                $numberPart = $matches[2];

                // リストから取得
                $course_info = division_list::where('division', $alphabetPart)->where('number', $numberPart)->first();
            }
        } elseif ($request['danken'] == 'true') {
            // 団研コース情報を取得
            $course_info = DankenLists::first();
            $request['cat'] = 'danken';
        }

        // 地区別の個数を取得
        $districtCounts = $entryInfos->groupBy('district')->map(function ($group) {
            return $group->count();
        });

        return view('admin_entry_infos.index')
            ->with(compact(['entryInfos', 'districtCounts']))
            ->with(isset($course_info) ? compact('course_info') : [])
            ->with(compact('request'));
    }

    /**
     * Show the form for creating a new Entry_info.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        // スカウトコース取得
        // SCはDBの取得結果がゼロでも問題ない
        $courselists = course_list::where('deadline', '>', now())->get();

        // 課程別研修取得
        $dls = division_list::select('division', 'number')->where('deadline', '>', now())->get();
        if (count($dls) == 0) {
            // 申込可能な課程別研修がなければ flashメッセージを表示してindexへリダイレクト
            flash::error('現在申し込める課程別研修がありません。管理者へお問い合わせ下さい。');
            return redirect()->route('entryInfos.index');
        } else {
            // 申込可能な課程別研修があれば配列化
            foreach ($dls as $dl) {
                $divisionlists[] = $dl->division . $dl->number;
            }
        }

        // 団研
        $danken = DankenLists::where('deadline', '>', now())->first();

        // 作成するユーザーデータ
        $id = $request->id;
        $user = User::where('id', $id)->first();

        return view('admin_entry_infos.create', compact('courselists', 'divisionlists', 'danken', 'user'));
    }

    /**
     * Store a newly created Entry_info in storage.
     *
     * @param CreateEntry_infoRequest $request
     *
     * @return Response
     */
    public function store(CreateEntry_infoRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['uuid'] = Uuid::uuid4();

        $entryInfo = $this->entryInfoRepository->create($input);

        Flash::success('申込データを登録しました');

        return redirect(route('admin_entryInfos.index'));
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
        $entryInfo = Entry_info::where('uuid', $id)->with('user')->first();

        if (empty($entryInfo)) {
            Flash::error('対象が見つかりません');

            return redirect(route('admin_entryInfos.index'));
        }

        // logging
        $user = $entryInfo->district . '地区 ' . $entryInfo->user->name;
        Log::channel('user_action')->info(Auth::user()->name . 'が ' . $user . 'の情報を表示しました');

        // 通知メールCC送信先取得
        $gm_email = GmAddress::where('uuid', $entryInfo->uuid)->first();

        return view('admin_entry_infos.show', compact('entryInfo', 'gm_email'));
    }

    /**
     * Show the form for editing the specified Entry_info.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $entryInfo = Entry_info::where('uuid', $id)->with('user')->first();
        // $user = User::where('id', $id)->first();
        // 生年月日分離
        $entryInfo->bd_year = $entryInfo->birthday->format('Y');
        $entryInfo->bd_month = $entryInfo->birthday->format('n');
        $entryInfo->bd_day = $entryInfo->birthday->format('j');

        if (empty($entryInfo)) {
            Flash::error('対象が見つかりません');

            return redirect(route('admin_entryInfos.index'));
        }

        // スカウトコース取得
        $courselists = course_list::all();

        // 課程別研修取得
        $dls = division_list::select('division', 'number')->get();
        foreach ($dls as $dl) {
            $divisionlists[] = $dl->division . $dl->number;
        }

        return view('admin_entry_infos.edit')->with(compact('entryInfo'))
            ->with(compact('courselists'))
            ->with(compact('divisionlists'));
    }

    /**
     * Update the specified Entry_info in storage.
     *
     * @param int $id
     * @param UpdateEntry_infoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEntry_infoRequest $request)
    {
        $entryInfo = $this->entryInfoRepository->find($id);

        if (empty($entryInfo)) {
            Flash::error('対象が見つかりません');

            return redirect(route('admin_entryInfos.index'));
        }

        $entryInfo = $this->entryInfoRepository->update($request->all(), $id);

        Flash::success($entryInfo->user->name . 'の申込情報を更新しました');

        return redirect(route('admin_entryInfos.index'));
    }

    /**
     * Remove the specified Entry_info from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $entryInfo = $this->entryInfoRepository->find($id);

        if (empty($entryInfo)) {
            Flash::error('対象が見つかりません');

            return redirect(route('admin_entryInfos.index'));
        }

        $entryInfo->health_info()->delete(); // 健康情報のcascade削除
        $this->entryInfoRepository->delete($id);

        Flash::success($entryInfo->user->name . 'の申込情報を削除しました');

        return redirect(route('admin_entryInfos.index'));
    }

    public function pdf(Request $request)
    {
        $id = $request['id'];
        // $entryInfo = User::where('id', $id)->with('entry_info')->first();
        $entryInfo = Entry_info::where('uuid', $id)->with('user')->first();

        $pdf = \PDF::loadView('entry_infos.pdf', compact('entryInfo'));
        $pdf->setPaper('A4');
        $filename = 'WB研修所・課程別研修申込書 ' . $entryInfo->district . ' ' . $entryInfo->user->name . '.pdf';
        return $pdf->download($filename);
        // return $pdf->stream();
    }

    public function multi_pdf(Request $request)
    // コース単位 全員の申込書PDF生成
    {
        if ($_REQUEST['cat'] == 'division') {
            // 課程別研修 申込書地区別
            if (Auth::user()->is_ais) {
                $entryInfos = Entry_info::where('division_number', $_REQUEST['q'])->where('district', Auth::user()->is_ais)->whereNotNull('div_accepted_at')->with('user')->get();
            } else {
                // 申込書全部
                $entryInfos = Entry_info::where('division_number', $_REQUEST['q'])->whereNotNull('div_accepted_at')->with('user')->get();
            }
        } elseif ($_REQUEST['cat'] == 'sc') {
            // スカウトコース 申込書地区別
            if (Auth::user()->is_ais) {
                $entryInfos = Entry_info::where('sc_number', $_REQUEST['q'])->where('district', Auth::user()->is_ais)->whereNotNull('sc_accepted_at')->with('user')->get();
            } else {
                // 申込書全部
                $entryInfos = Entry_Info::where('sc_number', $_REQUEST['q'])
                    ->whereNotNull('sc_accepted_at')
                    ->with('user')
                    ->get();
            }
        } elseif ($_REQUEST['cat'] == 'danken') {
            // 団研 申込書地区別
            if (Auth::user()->is_ais) {
                $entryInfos = Entry_info::whereNotNull('danken')->where('district', Auth::user()->is_ais)->whereNotNull('danken_accepted_at')->with('user')->get();
            } else {
                // 申込書全部
                $entryInfos = Entry_info::whereNotNull('danken')->whereNotNull('danken_accepted_at')->with('user')->get();
            }
        }


        if ($entryInfos->count() == 0) {
            flash::error('対象の申込がありません。もしくは参加認定前のため、一括ダウンロードができません。');
            return back();
        }

        // 一時ディレクトリを作成する
        $tmpDirName = 'tmp_' . Str::random(8);
        Storage::makeDirectory($tmpDirName);

        if ($request['assignment'] == 'false') {
            // 個別の申込書を生成
            foreach ($entryInfos as $entryInfo) {
                // 取れている
                $pdf = \PDF::loadView('entry_infos.pdf', compact('entryInfo'));
                $pdf->setPaper('A4');
                $pdf = $pdf->output(); // PDF生成

                switch ($_REQUEST['cat']) {
                    case 'sc':
                        $fname = $entryInfo->sc_number . " " . $entryInfo->district . " " . $entryInfo->user->name;
                        break;
                    case 'division':
                        $fname = $entryInfo->division_number . " " . $entryInfo->district . " " . $entryInfo->user->name;
                        break;
                    case 'danken':
                        $fname = "団研 " . $entryInfo->district . " " . $entryInfo->user->name;
                        break;
                    default:
                        # code...
                        break;
                }
                $fname = str_replace(' ', '_', $fname); // ファイル名のスペースを_に置換
                Storage::put($tmpDirName . "/" . $fname . '.pdf', $pdf);
            }
        } elseif ($request['assignment'] == 'true') {
            // 課題の一括DL
            foreach ($entryInfos as $entryInfo) {
                $uuid = $entryInfo->uuid;

                switch ($_REQUEST['cat']) {
                    case 'sc':
                        $fname = $entryInfo->sc_number . " " . $entryInfo->district . " " . $entryInfo->user->name;
                        break;
                    case 'division':
                        $fname = $entryInfo->division_number . " " . $entryInfo->district . " " . $entryInfo->user->name;
                        break;
                    case 'danken':
                        $fname = "団研 " . $entryInfo->district . " " . $entryInfo->user->name;
                        break;
                    default:
                        # code...
                        break;
                }
                $fname = str_replace(' ', '_', $fname) . '.pdf'; // ファイル名のスペースを_に置換
                if ($_REQUEST['cat'] == 'division') {
                    $srcPath = storage_path('app/public/assignment/division/') . $uuid . ".pdf";
                } else {
                    $srcPath = storage_path('app/public/assignment/sc/') . $uuid . ".pdf";
                }

                $dstPath = storage_path('app/') . $tmpDirName . '/' . $fname;
                if (File::exists($srcPath)) { // ファイルの存在を確認してコピー
                    File::copy($srcPath, $dstPath);
                }
            }
        }

        // zip生成
        switch ($_REQUEST['cat']) {
            case 'sc':
                $prefix = $entryInfo->sc_number;
                break;
            case 'division':
                $prefix = $entryInfo->division_number;
                break;
            case 'danken':
                $prefix = "団研 ";
                break;
            default:
                # code...
                break;
        }

        if ($request['assignment'] == 'false') {
            $fName = "申込書.zip";
        } elseif ($request['assignment'] == 'true') {
            $fName = "課題研修.zip";
        }

        $zipFileName = $prefix . $fName;

        $zipFilePath = storage_path('app/' . $zipFileName);
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            $files = Storage::files($tmpDirName);
            foreach ($files as $file) {
                $fileName = basename($file);
                if (Storage::exists($file)) {
                    $zip->addFile(storage_path('app/' . $file), $fileName);
                }
            }
            $zip->close();
        }

        // 一時ディレクトリ削除
        Storage::deleteDirectory($tmpDirName);
        // DLさせて末尾のdeleteAfterSend() で自動削除
        if (File::exists($zipFilePath)) {
            return response()->download($zipFilePath)->deleteFileAfterSend();
        } else {
            Flash::error('ダウンロード可能なファイルがありません');
            return back();
        }
    }

    public function ais_check(Request $request)
    {
        // AIS委員会のチェック機能
        $id = $request['id'];
        $entryInfo = Entry_info::where('uuid', $id)->with('user')->first();
        $entryInfo->ais_checked_at = now();
        $entryInfo->save();

        // 氏名取得
        $name = $entryInfo->user->name;

        // 確認メール送信
        // $sendto = $user->email;
        // 2023/07/08 地区AIS委員長のチェック結果は参加者に通知しないように仕様変更
        // Mail::to($sendto)->queue(new AisChecked($user->name)); // メールをqueueで送信


        // 名前+flashメッセージを返して戻る
        Flash::success($entryInfo->user->name . 'さん AIS委員会のチェックをしました');

        // slack通知
        $slack = new SlackPost();
        $slack->send(':white_check_mark:' . $entryInfo->district . '地区 ' . $name . ' さんの地区AIS委員長確認が完了しました');

        return back();
    }

    public function admin_export(Request $request)
    {
        if (isset($request->sc)) { // 一覧表からSC番号が指定されたとき
            if (Auth::user()->is_ais) {
                $data = Entry_info::with('user')->where('sc_number', $request->sc)->where('district', Auth::user()->is_ais)->with('health_info')->get();
            } else {
                $data = Entry_info::with('user')->where('sc_number', $request->sc)->with('health_info')->get();
            }
        } elseif (isset($request->division)) { // 一覧表からSC番号が指定されたとき
            if (Auth::user()->is_ais) {
                $data = Entry_info::with('user')->where('division_number', $request->division)->where('district', Auth::user()->is_ais)->get();
            } else {
                $data = Entry_info::with('user')->where('division_number', $request->division)->get();
            }
        } elseif (isset($request->cat) && $request->cat == 'danken') { // 一覧表から団研が指定されたとき
            if (Auth::user()->is_ais) {
                $data = Entry_info::with('user')->whereNotNull('danken')->where('district', Auth::user()->is_ais)->with('health_info')->get();
            } else {
                $data = Entry_info::with('user')->whereNotNull('danken')->with('health_info')->get();
            }
        } elseif ($_REQUEST['q'] == 'all') { // or 全件取得
            $data = Entry_info::with('user')->get();
        }

        // DLファイル名の指定
        if ($request->sc) {
            $filename = 'スカウトコース申込一覧 ' . $request->sc . '期.xlsx';
        } elseif ($request->division) {
            $filename = '課程別研修申込一覧 ' . $request->division . '回.xlsx';
        } elseif (isset($_REQUEST['q']) && $_REQUEST['q'] == 'all') {
            $filename = '指導者研修申込一覧.xlsx';
        } elseif ($request['cat'] == 'danken') {
            $filename = '団研申込一覧.xlsx';
        }

        //エクセルの見出しを以下で設定
        if ($request->cat == 'danken') {
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

    public function certificate_export(Request $request)
    {
        // 履修者のexport
        $cat = $request->cat;
        $q = $request->q;
        if ($cat == 'SC') {
            $data = Entry_info::where('sc_number', $q)->with('user')
                ->select('user_id', 'sc_number', 'dan', 'district', 'troop', 'troop_role')
                ->get();
            $prefix = 'SC' . $q;
        } elseif ($cat == 'division') {
            $data = Entry_info::where('division_number', $q)->with('user')
                ->select('user_id', 'division_number', 'dan', 'district', 'troop', 'troop_role')
                ->get();
            $prefix = '課程別_' . $q;
        } elseif ($cat == 'danken') {
            $data = Entry_info::whereNotNull('danken')->with('user')->get();
            $prefix = '団研';
        }

        // DLファイル名の指定
        $filename = '履修者名簿_' . $prefix . '.xlsx';

        //エクセルの見出しを以下で設定
        $headings = [
            'コース',
            '氏名',
            '団名',
            '地区',
            '隊',
            '役務',
        ];


        //以下で先ほど作成したExcelExportにデータを渡す。
        return Excel::download(new CertificateExport($data, $headings), $filename);
    }

    public function fee_check(Request $request)
    {
        $cat = $request['cat'];
        // 入金IDがあるとき
        if (isset($request['id'])) {
            $id = $request['id'];
            $entryinfo = Entry_info::where('id', $id)->with('user')->firstOrFail();
            if ($request['cat'] == 'sc') {
                $entryinfo->sc_fee_checked_at = now();
                $category = 'スカウトコース';
            } elseif ($request['cat'] == 'div') {
                $entryinfo->div_fee_checked_at = now();
                $category = '課程別研修';
            } elseif ($request['cat'] == 'danken') {
                $entryinfo->danken_fee_checked_at = now();
                $category = '団委員研修所';
            }
            $entryinfo->save();

            // メール送信機能を付ける
            // 確認メール送信
            $sendto = $entryinfo->user->email;
            $name = $entryinfo->user->name;
            $dist = $entryinfo->district;
            Mail::to($sendto)->queue(new FeeChecked($name, $cat)); // メールをqueueで送信

            // flashメッセージを設定
            Flash::success($entryinfo->user->name . 'の入金確認を行いました');

            // slack通知
            // disable slack notiofication from slack
            if (config('app.env') !== 'local') {
                $slack = new SlackPost();
                $slack->send(':moneybag:' . $dist . '地区 ' . $name . ' さんの ' . $category . ' 入金確認が完了しました');
            }

            // 一覧に戻る
            return back();
        } else {
            // 入金IDがなく、一覧を返す
            if ($cat == 'div') {
                // 課程別研修は全員拾う
                $entryinfos = Entry_info::with('user')->orderby('furigana')->get();
            } elseif ($cat == 'danken') {
                // 団研
                $entryinfos = Entry_info::whereNotNull('danken')->with('user')->orderby('furigana')->get();
            } elseif ($cat == 'sc') {
                // スカウトコース
                $entryinfos = Entry_info::where('sc_number', '<>', 'done')->with('user')->orderby('furigana')->get();
            }
            return view('fee_check.index')
                ->with(compact('entryinfos'));
        }
    }

    public function revert(Request $request)
    {
        // 取り消し機能
        $uuid = $request['uuid'];
        $cat = $request['cat'];
        $target = $request['target'];
        $entryInfo = Entry_info::where('uuid', $uuid)->first();

        // カテゴリによってnull化
        switch ($cat) {
            case 'dan':
                $entryInfo->gm_checked_at = null;
                $entryInfo->gm_name = null;
                $cat_name = '団承認';
                break;
            case 'trainer':
                if ($target == 'sc') {
                    $entryInfo->trainer_sc_checked_at = null;
                    $entryInfo->trainer_sc_name = null;
                    $entryInfo->trainer_danken_checked_at = null;
                    $entryInfo->trainer_danken_name = null;
                } elseif ($target == 'div') {
                    $entryInfo->trainer_division_checked_at = null;
                    $entryInfo->trainer_division_name = null;
                }
                $cat_name = 'トレーナー認定';
                break;
            case 'commi':
                $entryInfo->commi_checked_at = null;
                $cat_name = '地区コミ確認';
                break;
            case 'ais':
                $entryInfo->ais_checked_at = null;
                $cat_name = '地区AIS委員長確認';
                break;

            default:
                # code...
                break;
        }
        // 保存
        $entryInfo->save();

        // 氏名取得
        $user = User::where('id', $entryInfo->user_id)->first();

        // 確認メール送信
        // $sendto = $user->email;
        // Mail::to($sendto)->queue(new AisChecked($user->name)); // メールをqueueで送信


        // 名前+flashメッセージを返して戻る
        Flash::success($user->name . 'さんの ' . $cat_name . 'を取り消しました。');

        return back();
    }

    public function accept(Request $request)
    {
        // 参加認定機能
        $uuid = $request['uuid'];
        $cat = $request['cat'];
        $flag = $request['flag'];
        $revert = $request['revert'];
        $entryInfo = Entry_info::where('uuid', $uuid)->first();
        $gm_email = GmAddress::where('uuid', $uuid)->value('email'); // 団委員長CC送信用

        switch ($cat) {
            case 'sc':
                if ($flag == 'accept') {
                    $entryInfo->sc_accepted_at = now();
                } elseif ($flag == 'reject') {
                    $entryInfo->sc_rejected_at = now();
                } elseif ($revert == 'true') {
                    $entryInfo->sc_accepted_at = null;
                    $entryInfo->sc_rejected_at = null;
                }
                break;

            case 'div':
                if ($flag == 'accept') {
                    $entryInfo->div_accepted_at = now();
                } elseif ($flag == 'reject') {
                    $entryInfo->div_rejected_at = now();
                } elseif ($revert == 'true') {
                    $entryInfo->div_accepted_at = null;
                    $entryInfo->div_rejected_at = null;
                }
                break;

            case 'danken':
                if ($flag == 'accept') {
                    $entryInfo->danken_accepted_at = now();
                } elseif ($flag == 'reject') {
                    $entryInfo->danken_rejected_at = now();
                } elseif ($revert == 'true') {
                    $entryInfo->danken_accepted_at = null;
                    $entryInfo->danken_rejected_at = null;
                }
                break;

            default:
                # code...
                break;
        }


        // 保存
        $entryInfo->save();

        // 氏名取得
        $user = User::where('id', $entryInfo->user_id)->first();

        if ($cat == 'sc') {
            $cat_name = 'スカウトコース';
            $sc_number = $entryInfo->sc_number;
            $drive_url = course_list::where('number', $sc_number)->value('drive_url');
        } elseif ($cat == 'div') {
            $cat_name = '課程別研修';
            $division_number = $entryInfo->division_number;

            // 課程別研修の期数を取得
            preg_match('/([A-Za-z]+)([0-9]+)/', $entryInfo->division_number, $matches);
            // アルファベットと数字をそれぞれ変数に格納
            $alphabetPart = $matches[1];
            $numberPart = $matches[2];
            $drive_url = division_list::where('division', $alphabetPart)->where('number', $numberPart)->value('drive_url');
        } elseif ($cat = 'danken') {
            $cat_name = '団委員研修所';
            $danken_number = $entryInfo->danken;
            $drive_url = DankenLists::where('number', $danken_number)->value('drive_url');
        }

        if ($flag == 'accept') {
            $flag_status = '参加承認';
        } elseif ($flag == 'reject') {
            $flag_status = '参加否認';
        } elseif ($revert == 'true') {
            $flag_status = '参加承認・否認の初期化';
        }

        // 確認メール送信
        if ($flag == 'accept' || $flag == 'reject') {
            $sendto = $user->email;
            $name = $user->name;
            $mail = Mail::to($sendto);
            $ccRecipients = []; // CC送信先(配列で持つ必要あり)

            if (config('app.env') !== 'local') {
                $ccRecipients[] = 'ais@scout.tokyo'; // 最初のCC
            }

            // 団委員長CC用
            if ($gm_email !== null) {
                $ccRecipients[] = $gm_email; // 2番目のCC
            }

            $mail->cc($ccRecipients);

            $mail->queue(new AisAccepted(
                $name,
                $flag,
                $sc_number ?? null,
                $division_number ?? null,
                $danken_number ?? null,
                $drive_url ?? null
            )); // $name, $flagと一緒に課程別のコースを送る必要あり
        }


        // 名前+flashメッセージを返して戻る
        if ($flag == 'accept' || $flag == 'reject') {
            // 承認 or 否認の時
            Flash::success($user->name . 'さんの ' . $cat_name . 'の' . $flag_status . "をしました。<br>$user->name さんに案内メールを送信しました。");
        } elseif ($revert == 'true') {
            // 取消の時
            Flash::success($user->name . 'さんの ' . $cat_name . 'の' . $flag_status . 'をしました。');
        }

        return back();
    }

    public function certificate(Request $request)
    {
        if ($request['list'] == 'all') {

            $count = Entry_info::select('sc_number')->selectRaw('count(user_id) as count_sc_number')->groupBy('sc_number')->get();
            $count = $count->sortBy('sc_number'); // 期数毎にソート

            $div_count = Entry_info::select('division_number')->selectRaw('count(user_id) as count_division_number')->groupBy('division_number')->get();
            $div_count = $div_count->sortBy('division_number'); // 回数毎にソート

            // 団研をDBから取得
            $danken_count = DankenLists::whereNotNull('number')->select('number')->first();

            return view('certificate')->with(compact(['count', 'div_count', 'danken_count']));
        } else {
            // 修了認定
            $uuid = $request['uuid'];
            $cat =  $request['cat'];
            $status =  $request['status'];
            $entryInfo = Entry_info::where('uuid', $uuid)->firstorfail();

            switch ($cat) {
                case 'sc':
                    $entryInfo->certification_sc = $status;
                    break;
                case 'div':
                    $entryInfo->certification_div = $status;
                    break;
                case 'danken':
                    $entryInfo->certification_danken = $status;
                    break;
            }

            $entryInfo->save();

            // 氏名取得
            $user = User::where('id', $entryInfo->user_id)->first();

            // 確認メール送信
            // $sendto = $user->email;
            // Mail::to($sendto)->queue(new AisChecked($user->name)); // メールをqueueで送信


            // 名前+flashメッセージを返して戻る
            Flash::success($user->name . 'さん 修了認定をしました');

            return back();
        }
    }

    public function email_not_verified()
    {
        // メール未認証リストを取得
        $users = User::where('email_verified_at', null)
            // admin、地区AIS、地区コミは除外
            ->where(['is_admin' => 0, 'is_ais' => null, 'is_commi' => null])
            ->get();

        return view('admin_entry_infos.email_not_verified')
            ->with('users', $users);
    }

    public function health_memo(Request $request)
    {
        $entryinfos = HealthInfo::where(function ($query) {
            $query->where('treating_disease', '<>', 1)
                ->orWhere('health_status_last_3_months', '病気のため休んだ')
                ->orWhere('recent_health_status', '<>', 1)
                ->orWhere('doctor_advice', '<>', 1)
                ->orWhere('medical_history', '<>', 1)
                ->orWhere('food_allergies', '食物アレルギーがある');
        })
            // SC参加者の抽出
            ->when($request['sc_number'], function ($query) use ($request) {
                $query->whereHas('entry_Info', function ($subQuery) use ($request) {
                    $subQuery->where('sc_number', $request['sc_number']);
                });
            })
            // 団研参加者の抽出
            ->when($request['danken'], function ($query) use ($request) {
                $query->whereHas('entry_Info', function ($subQuery) use ($request) {
                    $subQuery->whereNotNull('danken');
                });
            })
            ->with(['user', 'entry_Info'])
            ->get();

        // 'done' 以外の sc_number を取得
        $uniqueScNumbers = Entry_info::where('sc_number', '<>', 'done')->distinct()->pluck('sc_number')->toArray();

        return view('admin_entry_infos.health_memo')
            ->with(compact(['entryinfos', 'uniqueScNumbers']));
    }

    public function save_user_memo(Request $request)
    {
        // メール未認証者のメモ保存
        $id = $request->input('user_id');
        $user = User::find($id);
        $user->memo = $request->input('memo');
        $user->save();

        Flash::success($user->name . ' さんのユーザーメモを登録しました');
        return redirect(route('email_not_verified'));
    }

    public function sendReminderEmailForFee(Request $request)
    {
        // dd($_REQUEST['cat']);
        // 参加督促ルール
        $id = $request['uuid'];
        $entryInfo = Entry_info::where('uuid', $id)->with('user')->first();
        // $entryInfo->cat = $_REQUEST['cat'];
        $cat = $_REQUEST['cat'];

        // 氏名取得
        $user = $entryInfo->user->name;

        // 確認メール送信
        $sendto = $entryInfo->user->email;
        Mail::to($sendto)->queue(new sendReminderEmailForFee($entryInfo, $cat)); // メールをqueueで送信


        // 名前+flashメッセージを返して戻る
        Flash::success($user . 'さん 参加費督促メールを送信しました。');

        // Log
        Log::channel('user_action')->info($user . 'さん 参加費督促メールを送信しました。');

        return back();
    }

    public function resetFeeCheckDate(Request $request)
    {
        // 入金日リセット
        $id = $request['uuid'];
        $entryInfo = Entry_info::where('uuid', $id)->with('user')->first();
        // $entryInfo->cat = $_REQUEST['cat'];
        $cat = $_REQUEST['cat'];


        // リセット処理
        if ($cat == 'sc') {
            $entryInfo->sc_fee_checked_at = NULL;
        } elseif ($cat == 'div') {
            $entryInfo->div_fee_checked_at = NULL;
        } elseif ($cat == 'danken') {
            $entryInfo->danken_fee_checked_at = NULL;
        }

        // DB更新
        $entryInfo->save();

        // 氏名取得
        $user = $entryInfo->user->name;

        // 確認メール送信
        $sendto = $entryInfo->user->email;
        // メールをqueueで送信
        Mail::to($sendto)->queue(new resetNoticeEmailForFee($entryInfo, $cat));

        // 名前+flashメッセージを返して戻る
        Flash::success($user . 'さん 参加費確認のリセットメールを送信しました。');

        // Log
        Log::channel('user_action')->info($user . 'さん 参加費確認リセットメールを送信しました。');

        return back();
    }

    public function create_user_data(Request $request)
    {
        if ($request->isMethod('get')) {
            // getの時はページ遷移
            // 参加データ未作成のレコードを抽出
            $users = User::where([
                ['is_admin', '=', 0],
                ['is_ais', '=', null],
                ['is_commi', '=', null],
                ['is_course_staff', '=', null],
            ])->whereDoesntHave('entry_info')->get();

            return view('admin_entry_infos.select_user')->with(compact('users'));
        } elseif ($request->isMethod('post')) {


            // flash
            // $name = $user->user->name;
            // Flash::success($name . 'さんのキャンセル情報を登録しました');

            return back();
        }
    }

    public function revert_cancel(Request $request)
    {
        // 欠席情報取消機能
        $input = $request->all();
        $uuid = $input['uuid'];

        try {
            $user = Entry_info::where('uuid', $uuid)->firstOrFail();
            switch ($input['cat']) {
                case 'sc':
                    $user->update(['cancel' => null]);
                    break;
                case 'div':
                    $user->update(['cancel_div' => null]);
                    break;
                default:
                    # code...
                    break;
            }

            flash::success('欠席情報を削除しました');
            return back();
        } catch (ModelNotFoundException $e) {
            // 該当するUUIDが見つからないときの処理
            Flash::error('当該レコードがありません');
            return back();
        }
    }

    public function approve_participation(Request $request)
    {
        $input = $request->all();

        if (isset($input['cat'])) {
            $cat  = $input['cat'];
            $number = $input['number'];
        }

        if (empty($cat)) {
            $count = Entry_info::select('sc_number')->selectRaw('count(user_id) as count_sc_number')->groupBy('sc_number')->get();
            $count = $count->sortBy('sc_number'); // 期数毎にソート

            $div_count = Entry_info::select('division_number')->selectRaw('count(user_id) as count_division_number')->groupBy('division_number')->get();
            $div_count = $div_count->sortBy('division_number'); // 回数毎にソート

            // 団研をDBから取得
            $danken_count = DankenLists::whereNotNull('number')->select('number')->first();

            return view('approve_participation.index')->with(compact(['count', 'div_count', 'danken_count']));
        } else {
            switch ($cat) {
                case 'sc':
                    $members = Entry_info::where('sc_number', $number)->whereNull('cancel')->with('user')->get();
                    return view('approve_participation.sc', compact('members'));
                    break;
                case 'div':
                    $members = Entry_info::where('division_number', $number)->whereNull('cancel_div')->with('user')->get();
                    return view('approve_participation.div', compact('members'));
                    break;
                case 'danken':
                    $members = Entry_info::whereNotNull('danken')->whereNull('cancel')->with('user')->get();
                    return view('approve_participation.danken', compact('members'));
                    break;
                default:
                    abort(404);
            }
        }
    }

    public function dl_face_pictures(Request $request)
    {
        $input = $request->all();
        $cat = $input['cat'];

        switch ($cat) {
            case 'sc':
                return $this->downloadByScNumber($input['number']);
            case 'div':
                return $this->downloadByDivisionNumber($input['number']);
            case 'danken':
                return $this->downloadByDanken();
            default:
                // 未定義のcatの場合の処理
                return redirect()->back()->with('error', '無効なパラメータが指定されました。');
        }
    }

    private function downloadByScNumber($number)
    {
        $users = Entry_info::where('sc_number', $number)->with('user')->get();
        $tempFolder = $this->createTempFolder();
        $this->copyAndRenameFiles($users, $tempFolder);
        $zipFile = $this->createZipFile($tempFolder, 'SC' . $number . '期_顔写真.zip');
        return $this->downloadAndCleanup($zipFile, $tempFolder);
    }

    private function downloadByDivisionNumber($number)
    {
        $users = Entry_info::where('division_number', $number)->with('user')->get();
        $tempFolder = $this->createTempFolder();
        $this->copyAndRenameFiles($users, $tempFolder);
        $zipFile = $this->createZipFile($tempFolder, '課程別' . $number . '回_顔写真.zip');
        return $this->downloadAndCleanup($zipFile, $tempFolder);
    }

    private function downloadByDanken()
    {
        $users = Entry_info::whereNotNull('danken')->whereNotNull('danken_accepted_at')->with('user')->get();
        $tempFolder = $this->createTempFolder();
        $this->copyAndRenameFiles($users, $tempFolder);
        $zipFile = $this->createZipFile($tempFolder, '団研'  . '_顔写真.zip');
        return $this->downloadAndCleanup($zipFile, $tempFolder);
    }

    private function createTempFolder()
    {
        $tempFolder = storage_path('app/public/temp/' . uniqid());
        if (!is_dir($tempFolder)) {
            mkdir($tempFolder, 0755, true);
        }
        return $tempFolder;
    }

    private function copyAndRenameFiles($users, $tempFolder)
    {
        foreach ($users as $user) {
            $pictures = [$user->user->face_picture];
            foreach ($pictures as $picture) {
                $source = storage_path('app/public/picture/' . $picture);
                $destination = $tempFolder . '/' . $picture;
                // 画像パスとファイル実態があるか確認してからcopy処理
                if (file_exists($source) && is_file($source)) {
                    copy($source, $destination);
                    $newDestination = $tempFolder . '/' . $user->district . '_' . $user->dan . '_' . $user->user->name . '.jpg';
                    rename($destination, $newDestination);
                }
            }
        }
    }

    private function createZipFile($tempFolder, $zipFileName)
    {
        $zipPath = storage_path('app/public/' . $zipFileName);
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($tempFolder)
            );
            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($tempFolder) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
            return $zipPath;
        } else {
            return null;
        }
    }

    private function downloadAndCleanup($zipPath, $tempFolder)
    {
        if ($zipPath && file_exists($zipPath)) {
            $response = response()->download($zipPath)->deleteFileAfterSend(true);
            File::deleteDirectory($tempFolder);
            return $response;
        } else {
            File::deleteDirectory($tempFolder);
            return redirect()->back()->with('error', 'zipファイルの生成に失敗しました。');
        }
    }
}
