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
use App\Models\GmAddress;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommiChecked;
use App\Mail\TrainerRequest;
use App\Mail\GmRequest;
use App\Http\Util\SlackPost;

class CommiEntry_infoController extends AppBaseController
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
        $entryInfos = Entry_info::where('district', Auth::user()->is_commi)->with('user')->get();

        return view('commi_entry_infos.index')
            ->with(compact('entryInfos'));
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
        // $entryInfo = User::where('id', $id)->with('entry_info')->with('health_info')->first();
        $entryInfo = Entry_info::where('uuid', $id)->with('user')->with('health_info')->first();
        // dd($entryInfo);

        if (empty($entryInfo)) {
            Flash::error('対象が見つかりません');

            return redirect(route('commi_entryInfos.index'));
        }

        // 通知メールCC送信先取得
        $gm_email = GmAddress::where('uuid', $id)->first();

        return view('commi_entry_infos.show', compact('entryInfo', 'gm_email'));
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

        Flash::success('申込情報を更新しました');

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

        Flash::success('申込情報を削除しました');

        return redirect(route('admin_entryInfos.index'));
    }

    public function pdf(Request $request)
    {
        $id = $request['id'];
        // $entryInfo = User::where('id', $id)->with('entry_info')->first();
        $entryInfo = Entry_info::where('uuid', $id)->with('user')->first();

        $pdf = \PDF::loadView('entry_infos.pdf', compact('entryInfo'));
        $filename = 'WB研修所・課程別研修申込書 ' . $entryInfo->district . ' ' . $entryInfo->user->name . '.pdf';
        // $pdf->setPaper('A4');
        return $pdf->download($filename);
        // return $pdf->stream();
    }

    public function commi_check(Request $request)
    {
        // 地区コミのチェック機能
        $id = $request['id'];
        $entryInfo = Entry_info::where('uuid', $id)->with('user')->first();
        $entryInfo->commi_checked_at = now();
        $entryInfo->save();

        // 確認メール送信
        $sendto = $entryInfo->user->email;
        Mail::to($sendto)->queue(new CommiChecked($entryInfo->user->name)); // メールをqueueで送信

        // slack通知
        $slack = new SlackPost();
        $slack->send(':white_check_mark:' . $entryInfo->district . '地区 ' . $entryInfo->user->name . ' さんの地区コミ推薦が行われました');


        // 名前+flashメッセージを返して戻る
        Flash::success($entryInfo->user->name . 'さん 地区コミのチェックをしました');

        return back();
    }

    public function trainer_request(Request $request)
    {
        $uuid = $request['id'];
        $userinfo = Entry_info::where('uuid', $uuid)->with('user')->firstOrFail();

        return view('commi_entry_infos.trainer_request')->with('userinfo', $userinfo);
    }

    public function trainer_request_send(Request $request)
    {
        $uuid = $request['uuid'];
        $name = User::whereHas('entry_info', function ($query) use ($uuid) {
            $query->where('uuid', $uuid);
        })->with('entry_info')->value('name');
        $sendto = $request['email'];
        $trainer_name = $request['name'];
        // 確認メール送信
        Mail::to($sendto)->queue(new TrainerRequest($name, $uuid, $trainer_name)); // メールをqueueで送信

        // 送信日打刻
        $ef = Entry_info::where('uuid', $uuid)->first();
        $ef->trainer_sent_at = now();
        $ef->save();

        Flash::success($trainer_name . 'さんにトレーナー認定依頼メールを発送しました');
        return back();
    }

    public function gm_request(Request $request)
    {
        $uuid = $request['id'];
        $userinfo = Entry_info::where('uuid', $uuid)->with('user')->firstOrFail();

        return view('commi_entry_infos.gm_request')->with('userinfo', $userinfo);
    }

    public function gm_request_send(Request $request)
    {
        $uuid = $request['uuid'];
        $name = User::whereHas('entry_info', function ($query) use ($uuid) {
            $query->where('uuid', $uuid);
        })->with('entry_info')->value('name');
        $sendto = $request['email'];
        $gm_name = $request['name'];
        // 確認メール送信
        Mail::to($sendto)->queue(new GmRequest($gm_name, $uuid, $name)); // メールをqueueで送信

        // 送信日打刻
        $ef = Entry_info::where('uuid', $uuid)->first();
        $ef->gm_sent_at = now();
        $ef->save();

        Flash::success($gm_name . 'さんに参加承認の依頼メールを発送しました');
        return back();
    }

    public function commi_comment(Request $request)
    {
        $id = $request['id'];
        $userinfo = Entry_info::where('uuid', $id)->with('user')->firstOrFail();

        return view('commi_entry_infos.commi_comment')->with('userinfo', $userinfo);
    }

    public function commi_comment_post(Request $request)
    {
        $input = $request->all();

        $userinfo = Entry_info::where('uuid', $input['uuid'])->with('user')->firstOrFail();
        $userinfo->additional_comment = $input['comment'];
        $userinfo->save();

        Flash::success($userinfo->user->name . 'さんの副申請書を作成しました。');

        $entryInfos = Entry_info::where('district', Auth::user()->is_commi)->with('user')->get();

        return view('commi_entry_infos.index')
            ->with('entryInfos', $entryInfos);
    }

    public function priority(Request $request)
    {
        // whereHas構文で子テーブルの条件で絞れる
        // $entryInfos = User::whereHas('entry_info', function ($query) {
        //     $query->where('district', Auth::user()->is_commi);
        // })->with(['entry_info' => function ($query) {
        //     $query->orderBy('order', 'asc');
        // }])->get();
        $entryInfos = Entry_info::where('district', Auth::user()->is_commi)->with('user')->orderBy('order', 'asc')->get();

        return view('commi_entry_infos.priority')
            ->with('entryInfos', $entryInfos);
    }

    // 優先順位ソート
    public function priority_sortable(Request $request)
    {
        // dd($request);
        $entryInfos = Entry_info::all();

        foreach ($entryInfos as $entryinfo) {
            foreach ($request->order as $order) {
                if ($order['id'] == $entryinfo->id) {
                    $entryinfo->update(['order' => $order['position']]);
                }
            }
        }

        return response('Update Successfully.', 200);
    }

    public function payment(Request $request)
    {
        // 参加費納入状況
        $users = Entry_info::where('district', Auth::user()->is_commi)->with('user')->orderBy('order', 'asc')->get();

        return view('commi_entry_infos.payment_status')
            ->with(compact('users'));
    }
}
