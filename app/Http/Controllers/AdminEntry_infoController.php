<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\DB; // excel export用
use App\Exports\ExcelExport; // excel export用
use Maatwebsite\Excel\Facades\Excel; // excel export用
use ZipArchive; // zipで固める
use Storage;
use App\Mail\FeeChecked;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Http\Util\Slack\SlackPost;
use App\Mail\AisAccepted;

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
        if (isset($request['q'])) { // スカウトコース 期数抽出
            if (Auth::user()->is_staff) {
                $entryInfos = User::wherehas(
                    'entry_info',
                    function ($query) {
                        $q = $_REQUEST['q'];
                        $query->where('sc_number', $q)->where('district', Auth::user()->is_staff);
                    }
                )->with('entry_info')->get();
            } else {
                $entryInfos = User::wherehas(
                    'entry_info',
                    function ($query) {
                        $q = $_REQUEST['q'];
                        $query->where('sc_number', $q);
                    }
                )->with('entry_info')->get();
            }
        } elseif (isset($request['div'])) { // 課程別研修 回数抽出
            if (Auth::user()->is_staff) {
                $entryInfos = User::wherehas(
                    'entry_info',
                    function ($query) {
                        $q = $_REQUEST['div'];
                        $query->where('division_number', $q)->where('district', Auth::user()->is_staff);
                    }
                )->with('entry_info')->get();
            } else {
                $entryInfos = User::wherehas(
                    'entry_info',
                    function ($query) {
                        $q = $_REQUEST['div'];
                        $query->where('division_number', $q);
                    }
                )->with('entry_info')->get();
            }
        } else {
            if (Auth::user()->is_staff) {
                $entryInfos = User::with('entry_info')
                    ->where('is_admin', 0)
                    ->where('is_staff', NULL)
                    ->where('is_commi', NULL)
                    ->whereHas('entry_info', function ($query) {
                        $query->where('district', Auth::user()->is_staff);
                    })
                    ->get();
            } else {
                $entryInfos = User::with('entry_info')
                    ->where('is_admin', 0)
                    ->where('is_staff', NULL)
                    ->where('is_commi', NULL)
                    ->get();
            }
        }

        if ($request['q']) {
            $request['cat'] = 'sc';
        } elseif ($request['div']) {
            $request['cat'] = 'div';
        }


        return view('admin_entry_infos.index')
            ->with('entryInfos', $entryInfos)->with('request', $request);
    }

    /**
     * Show the form for creating a new Entry_info.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin_entry_infos.create');
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
        $entryInfo = User::where('id', $id)->with('entry_info')->first();

        if (empty($entryInfo)) {
            Flash::error('対象が見つかりません');

            return redirect(route('admin_entryInfos.index'));
        }

        return view('admin_entry_infos.show')->with('entryInfo', $entryInfo);
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
        $entryInfo = Entry_info::where('user_id', $id)->first();
        $user = User::where('id', $id)->first();
        // 生年月日分離
        $entryInfo->bd_year = $entryInfo->birthday->format('Y');
        $entryInfo->bd_month = $entryInfo->birthday->format('n');
        $entryInfo->bd_day = $entryInfo->birthday->format('j');

        if (empty($entryInfo)) {
            Flash::error('対象が見つかりません');

            return redirect(route('admin_entryInfos.index'));
        }

        return view('admin_entry_infos.edit')->with('entryInfo', $entryInfo)->with('user', $user);
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

        $this->entryInfoRepository->delete($id);

        Flash::success($entryInfo->user->name . 'の申込情報を削除しました');

        return redirect(route('admin_entryInfos.index'));
    }

    public function pdf(Request $request)
    {
        $id = $request['id'];
        $entryInfo = User::where('id', $id)->with('entry_info')->first();

        $pdf = \PDF::loadView('entry_infos.pdf', compact('entryInfo'));
        $pdf->setPaper('A4');
        $filename = 'WB研修所・課程別研修申込書 ' . $entryInfo->entry_info->district . ' ' . $entryInfo->name . '.pdf';
        return $pdf->download($filename);
        // return $pdf->stream();
    }

    public function multi_pdf(Request $request)
    // コース単位 全員の申込書PDF生成
    {
        if ($_REQUEST['cat'] == 'division') {
            // 課程別研修 申込書地区別
            if (Auth::user()->is_staff) {
                $entryInfos = User::wherehas(
                    'entry_info',
                    function ($query) {
                        $q = $_REQUEST['q'];
                        $query->where('division_number', $q)->where('district', Auth::user()->is_staff);
                    }
                )->with('entry_info')->get();
            } else {
                // 申込書全部
                $entryInfos = User::wherehas(
                    'entry_info',
                    function ($query) {
                        $q = $_REQUEST['q'];
                        $query->where('division_number', $q);
                    }
                )->with('entry_info')->get();
            }
        } elseif ($_REQUEST['cat'] == 'sc') {
            // スカウトコース 申込書地区別
            if (Auth::user()->is_staff) {
                $entryInfos = User::wherehas(
                    'entry_info',
                    function ($query) {
                        $q = $_REQUEST['q'];
                        $query->where('sc_number', $q)->where('district', Auth::user()->is_staff);
                    }
                )->with('entry_info')->get();
            } else {
                // 申込書全部
                $entryInfos = User::wherehas(
                    'entry_info',
                    function ($query) {
                        $q = $_REQUEST['q'];
                        $query->where('sc_number', $q);
                    }
                )->with('entry_info')->get();
            }
        }



        // 一時ディレクトリを作成する
        $tmpDirName = 'tmp_' . Str::random(8);
        Storage::makeDirectory($tmpDirName);

        if ($request['assignment'] == 'false') {
            // 個別の申込書を生成
            foreach ($entryInfos as $entryInfo) {
                $pdf = \PDF::loadView('entry_infos.pdf', compact('entryInfo'));
                $pdf->setPaper('A4');
                $pdf = $pdf->output(); // PDF生成
                $fname = $entryInfo->entry_info->sc_number . " " . $entryInfo->entry_info->district . " " . $entryInfo->name; // ファイル名
                $fname = str_replace(' ', '_', $fname); // ファイル名のスペースを_に置換
                Storage::put($tmpDirName . "/" . $fname . '.pdf', $pdf);
            }
        } elseif ($request['assignment'] == 'true') {
            // 課題の一括DL
            foreach ($entryInfos as $entryInfo) {
                $uuid = $entryInfo->entry_info->uuid;
                $fname = $entryInfo->entry_info->sc_number . " " . $entryInfo->entry_info->district . " " . $entryInfo->name . " 課題"; // ファイル名
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
        if ($request['assignment'] == 'false') {
            $zipFileName = "sc_entry_all.zip";
        } elseif ($request['assignment'] == 'true') {
            $zipFileName = "sc_assignment_all.zip";
        }
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
        $entryInfo = Entry_info::where('id', $id)->first();
        $entryInfo->ais_checked_at = now();
        $entryInfo->save();

        // 氏名取得
        $user = User::where('id', $entryInfo->user_id)->first();

        // 確認メール送信
        $sendto = $user->email;
        // 2023/07/08 地区AIS委員長のチェック結果は参加者に通知しないように仕様変更
        // Mail::to($sendto)->queue(new AisChecked($user->name)); // メールをqueueで送信


        // 名前+flashメッセージを返して戻る
        Flash::success($user->name . 'さん AIS委員会のチェックをしました');

        // slack通知
        $slack = new SlackPost();
        $slack->send(':white_check_mark:' . $entryInfo->district . '地区 ' . $user->name . ' さんの地区AIS委員長確認が完了しました');

        return back();
    }

    public function admin_export(Request $request)
    {
        if (isset($request->sc)) { // 一覧表からSC番号が指定されたとき
            if (Auth::user()->is_staff) {
                $data = Entry_info::with('user')->where('sc_number', $request->sc)->where('district', Auth::user()->is_staff)->get();
            } else {
                $data = Entry_info::with('user')->where('sc_number', $request->sc)->get();
            }
        } elseif (isset($request->division)) { // 一覧表からSC番号が指定されたとき
            if (Auth::user()->is_staff) {
                $data = Entry_info::with('user')->where('division_number', $request->division)->where('district', Auth::user()->is_staff)->get();
            } else {
                $data = Entry_info::with('user')->where('division_number', $request->division)->get();
            }
        } else { // or 全県取得
            $data = Entry_info::with('user')->get();
        }

        // DLファイル名の指定
        if ($request->sc) {
            $filename = 'スカウトコース申込一覧 ' . $request->sc . '期.xlsx';
        } elseif ($request->division) {
            $filename = '課程別研修申込一覧 ' . $request->division . '回.xlsx';
        } else {
            $filename = '申込一覧.xlsx';
        }

        //エクセルの見出しを以下で設定
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
        ];

        //以下で先ほど作成したExcelExportにデータを渡す。
        return Excel::download(new ExcelExport($data, $headings), $filename);
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
            $slack = new SlackPost();
            $slack->send(':moneybag:' . $dist . '地区 ' . $name . ' さんの ' . $category . ' 入金確認が完了しました');

            // 一覧に戻る
            return back();
        } else {
            // 入金IDがなく、一覧を返す
            if ($cat == 'div') {
                // 課程別研修は全員拾う
                $entryinfos = Entry_info::with('user')->orderby('furigana')->get();
            } else {
                // 修了済みスカウトコースの期数がブランクを拾う
                $entryinfos = Entry_info::where('sc_number_done', null)->with('user')->orderby('furigana')->get();
            }

            return view('fee_check.index')
                ->with('entryinfos', $entryinfos);
        }
    }

    public function revert(Request $request)
    {
        // 取り消し機能
        $uuid = $request['uuid'];
        $cat = $request['cat'];
        $entryInfo = Entry_info::where('uuid', $uuid)->first();

        // カテゴリによってnull化
        switch ($cat) {
            case 'dan':
                $entryInfo->gm_checked_at = null;
                $entryInfo->gm_name = null;
                $cat_name = '団承認';
                break;
            case 'trainer':
                $entryInfo->trainer_sc_checked_at = null;
                $entryInfo->trainer_sc_name = null;
                $entryInfo->trainer_division_checked_at = null;
                $entryInfo->trainer_division_name = null;
                // $entryInfo->assignment_sc = null;
                // $entryInfo->assignment_division = null;
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
        } else {
            $cat_name = '課程別研修';
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
            Mail::to($sendto)
                ->cc('ais@scout.tokyo')
                ->queue(new AisAccepted($name, $flag)); // メールをqueueで送信
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

            return view('certificate')->with('count', $count)->with('div_count', $div_count);
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
            }

            $entryInfo->save();

            // 氏名取得
            $user = User::where('id', $entryInfo->user_id)->first();

            // 確認メール送信
            // $sendto = $user->email;
            // Mail::to($sendto)->queue(new AisChecked($user->name)); // メールをqueueで送信


            // 名前+flashメッセージを返して戻る
            Flash::success($user->name . 'さん 参加認定をしました');

            return back();
        }
    }
}
