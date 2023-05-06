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
use App\Mail\InputRegisterd;
use Storage;
use App\Models\course_list;
use App\Models\division_list;

class Entry_infoController extends AppBaseController
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
        // $entryInfos = $this->entryInfoRepository->all();
        $entryInfo = Entry_info::where('user_id', Auth::user()->id)->first();

        return view('entry_infos.index')
            ->with('entryInfo', $entryInfo);
    }

    /**
     * Show the form for creating a new Entry_info.
     *
     * @return Response
     */
    public function create()
    {
        // 重複入力はブロック
        $entryInfo = Entry_info::where('user_id', Auth::user()->id)->first();
        if($entryInfo){
            Flash::success('既に申込データが存在します。複数の申込をすることはできません。');
            return view('home'); // homeにリダイレクト
        }

        // スカウトコース取得
        $courselists = course_list::all();

        // 課程別研修取得
        $dls = division_list::select('division', 'number')->get();
        foreach ($dls as $dl) {
            $divisionlists[] = $dl->division . $dl->number;
        }

        return view('entry_infos.create', compact('courselists', 'divisionlists'));
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

        // SC期数が現行の期数が選択されていて、かつ、修了済みのSC期数が入力されている場合
        // sc_number_doneをnull化する
        if ($input['sc_number'] !== 'done') {
            $input['sc_number_done'] = NULL;
        }


        $entryInfo = $this->entryInfoRepository->create($input);

        Flash::success('申込データを登録しました');

        // 確認メール送信
        $sendto = User::where('id', $input['user_id'])->first();
        Mail::to($sendto->email)->queue(new InputRegisterd($sendto->name)); // メールをqueueで送信

        return redirect(route('entryInfos.index'));
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
        $entryInfo = $this->entryInfoRepository->find($id);

        if (empty($entryInfo)) {
            Flash::error('Entry Info not found');

            return redirect(route('entryInfos.index'));
        }

        return view('entry_infos.show')->with('entryInfo', $entryInfo);
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
        $entryInfo = $this->entryInfoRepository->find($id);
        // 生年月日分離
        $entryInfo->bd_year = $entryInfo->birthday->format('Y');
        $entryInfo->bd_month = $entryInfo->birthday->format('n');
        $entryInfo->bd_day = $entryInfo->birthday->format('j');

        // スカウトコース取得
        $courselists = course_list::all();

        // 課程別研修取得
        $dls = division_list::select('division', 'number')->get();
        foreach ($dls as $dl) {
            $divisionlists[] = $dl->division . $dl->number;
        }

        if (empty($entryInfo)) {
            Flash::error('Entry Info not found');

            return redirect(route('entryInfos.index'));
        }

        return view('entry_infos.edit', compact('entryInfo', 'courselists', 'divisionlists'));
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
        // dd($entryInfo);

        if (empty($entryInfo)) {
            Flash::error('Entry Info not found');

            return redirect(route('entryInfos.index'));
        }

        $entryInfo = $this->entryInfoRepository->update($request->all(), $id);

        Flash::success('申込情報を更新しました');

        return redirect(route('entryInfos.index'));
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
            Flash::error('Entry Info not found');

            return redirect(route('entryInfos.index'));
        }

        $this->entryInfoRepository->delete($id);

        Flash::success('申込情報を削除しました');

        return redirect(route('entryInfos.index'));
    }

    public function pdf()
    {
        $entryInfo = User::where('id', Auth::id())->with('entry_info')->first();
        // $entryInfo = Entry_info::where('user_id',Auth::id())->with('user')->first();
        // dd($entryInfo);

        $pdf = \PDF::loadView('entry_infos.pdf', compact('entryInfo', $entryInfo));
        $pdf->setPaper('A4');
        return $pdf->download();
        // return $pdf->stream();
    }

    public function delete_file(Request $request)
    // ファイルの削除
    {
        $q = $request['q'];
        $id = $request['id'];

        // 申込レコード取得
        $entryinfo = Entry_info::where('uuid', $id)->first();
        $user = User::where('id', Auth::id())->first();

        // pathを取得して、課題カラムをNULL化
        if ($q == 'sc') {
            $path = "assignment/sc/$id.pdf";
            $entryinfo->assignment_sc = NULL;
            $entryinfo->save();
        } elseif ($q == 'division') {
            $path = "assignment/division/$id.pdf";
            $entryinfo->assignment_division = NULL;
            $entryinfo->save();
        } elseif ($q == 'face') {
            $path = "picture/$id";
            $user->face_picture = NULL;
            $user->save();
        }

        // ファイル削除
        if ($path !== '') {
            Storage::disk('public')->delete($path);
        }

        Flash::success('削除しました');

        return redirect(route('entryInfos.index'));
    }
}
