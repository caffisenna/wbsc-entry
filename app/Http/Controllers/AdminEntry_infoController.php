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
        $entryInfos = User::with('entry_info')
            ->where('is_admin', 0)
            ->where('is_staff', 0)
            ->where('is_commi', NULL)
            ->get();

        return view('admin_entry_infos.index')
            ->with('entryInfos', $entryInfos);
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

        Flash::success($entryInfo->user->name.'の申込情報を更新しました');

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

        Flash::success($entryInfo->user->name.'の申込情報を削除しました');

        return redirect(route('admin_entryInfos.index'));
    }

    public function pdf(Request $request)
    {
        $id = $request['id'];
        $entryInfo = User::where('id', $id)->with('entry_info')->first();

        $pdf = \PDF::loadView('entry_infos.pdf', compact('entryInfo', $entryInfo));
        $pdf->setPaper('A4');
        return $pdf->download();
        // return $pdf->stream();
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
        Mail::to($sendto)->queue(new AisChecked($user->name)); // メールをqueueで送信


        // 名前+flashメッセージを返して戻る
        Flash::success($user->name . 'さん AIS委員会のチェックをしました');

        return back();
    }

    public function admin_export()
    {
        // $data = User::with('entry_info')->get();
        $data = Entry_info::with('user')->get();
        // dd($data);
        $filename = 'export.' . 'xlsx'; //ファイル名
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
}
