<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEntry_infoRequest;
use App\Http\Requests\UpdateEntry_infoRequest;
use App\Repositories\Entry_infoRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateHealth_infoRequest;
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
use App\Models\DankenLists;
use App\Http\Util\SlackPost;
use App\Models\HealthInfo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        $entryInfo = Entry_info::where('user_id', Auth::user()->id)->with('user')->first();
        // $danken = DankenLists::firstorFail();
        $danken = DankenLists::where('deadline', '>', now())->first();
        $healthInfo = HealthInfo::where('user_id', Auth::user()->id)->first();

        return view('entry_infos.index')
            ->with(compact(['entryInfo', 'danken', 'healthInfo']));
    }

    /**
     * Show the form for creating a new Entry_info.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        // 重複入力はブロック
        $entryInfo = Entry_info::where('user_id', Auth::user()->id)->first();
        if ($entryInfo) {
            Flash::error('既に申込データが存在します。複数の申込をすることはできません。');
            return view('home'); // homeにリダイレクト
        }

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
        if ($danken) {
            if ($request->cat == 'danken') {
                $danken->cat = 'danken';
            }
        } else {
            // flash::error('申込可能な団委員研修所がありません');
            // return back();
        }

        return view('entry_infos.create', compact('courselists', 'divisionlists', 'danken'));
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
        // 重複入力はブロック
        $entryInfo = Entry_info::where('user_id', Auth::user()->id)->first();
        if ($entryInfo) {
            Flash::error("既に申込データが存在します。複数の申込をすることはできません。<br>
            データの修正が必要な場合は修正を行ってください。");
            return view('home'); // homeにリダイレクト
        }

        $input = $request->all();

        if (isset($input['create_id'])) {
            $input['user_id'] = $input['create_id'];
        } else {
            $input['user_id'] = Auth::user()->id;
        }

        $input['uuid'] = Uuid::uuid4();

        // SC期数が現行の期数が選択されていて、かつ、修了済みのSC期数が入力されている場合
        // sc_number_doneをnull化する
        if (isset($input['sc_number'])) {
            if ($input['sc_number'] !== 'done') {
                $input['sc_number_done'] = NULL;
            }
        }

        // ビーバー課程特例処理
        // if($input['bvs_exception'] == 'on'){
        //     $input['sc_number'] = null;
        // }


        $entryInfo = $this->entryInfoRepository->create($input);

        Flash::success('申込データを登録しました');

        // 確認メール送信
        $sendto = User::where('id', $input['user_id'])->first();
        Mail::to($sendto->email)->queue(new InputRegisterd($sendto->name)); // メールをqueueで送信

        // Slackアラート通知
        // スカウトコース総数
        if (isset($request['sc_number']) && $request['sc_number'] != 'done') {
            $sc_count = Entry_info::where('sc_number', $request['sc_number'])->count();
        }
        // 課程別総数
        $div_count = Entry_info::where('division_number', $request['division_number'])->count();

        // 団研総数
        $danken_count = Entry_info::where('danken', 'true')->count();

        if (config('app.env') !== 'local') {
            // ローカル環境ではslackの通知を出さない
            $slack = new SlackPost();
            if ($request['sc_number'] == 'done') {
                $slack->send(
                    ":new: " . $input['district'] . '地区 ' . $sendto->name . "さんが申込情報を入力しました\n" .
                        "課程別研修のみ: " . $input['division_number'] . "回 (トータル: $div_count 人)"
                );
            } else {
                $message = ":new: " . $input['district'] . '地区 ' . $sendto->name . "さんが申込情報を入力しました\n";

                if (isset($input['sc_number'])) {
                    $message .=
                        "スカウトコース: " . $input['sc_number'] . "期 (トータル: $sc_count 人)\n" .
                        "課程別研修: " . $input['division_number'] . "回 (トータル: $div_count 人)\n";
                }

                $message .= "団研: $danken_count 人\n";

                $slack->send($message);
            }
        } else {
            // dd(config('app.env'));
        }


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
            Flash::error('データが見つかりません');

            return redirect(route('entryInfos.index'));
        }

        if ($entryInfo->user_id == Auth::id()) {
            return view('entry_infos.show')->with('entryInfo', $entryInfo);
        } else {
            Flash::warning('そのデータは閲覧権限がありません');
            return back();
        }
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

        if ($entryInfo->user_id == Auth::id()) {
            return view('entry_infos.edit', compact('entryInfo', 'courselists', 'divisionlists'));
        } else {
            Flash::warning('そのデータは閲覧権限がありません');
            return view('home');
        }
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
            Flash::error('Entry Info not found');

            return redirect(route('entryInfos.index'));
        }

        // ビーバー課程特例処理
        // if($request['bvs_exception'] == 'on'){
        //     $request['sc_number'] = null;
        // }

        $entryInfo = $this->entryInfoRepository->update($request->all(), $id);

        // logging
        Log::channel('user_action')->info($entryInfo->district . '地区 ' . Auth::user()->name . "が参加者情報を編集しました");

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
        $entryInfo = Entry_Info::where('user_id', Auth::id())->with('user')->with('health_info')->first();

        $pdf = \PDF::loadView('entry_infos.pdf', compact('entryInfo'));
        $pdf->setPaper('A4');
        return $pdf->download('WB研修所申込書 ' . $entryInfo->name . '.pdf');
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
            $entryinfo->assignment_danken = NULL;
            $entryinfo->save();
            $cat = 'スカウトコース課題/団研課題';
        } elseif ($q == 'division') {
            $path = "assignment/division/$id.pdf";
            $entryinfo->assignment_division = NULL;
            $entryinfo->save();
            $cat = '課程別研修課題';
        } elseif ($q == 'face') {
            $path = "picture/$user->face_picture";
            $user->face_picture = NULL;
            $user->save();
            $cat = '顔写真';
        }

        // ファイル削除
        if ($path !== '') {
            Storage::disk('public')->delete($path);
        }

        Flash::success('削除しました');
        Log::channel('user_action')->info($entryinfo->district . '地区 ' . $user->name . ' ' . $cat . 'を削除しました');

        return redirect(route('entryInfos.index'));
    }

    public function health_info(Request $request)
    {
        if ($request->isMethod('get')) {
            // getの時はページ遷移
            $user = User::where('email', auth::user()->email)->with('entry_info')->with('health_info')->firstOrFail();

            if ($user->entry_info === null) {
                flash::error('<span uk-icon="icon: warning"></span>申込データがありません。最初に申込データを作成してください');
                return redirect(route('entryInfos.index'));
            }

            return view('entry_infos.health_info')->with(compact('user'));
        } elseif ($request->isMethod('post')) {
            // postの時はDB更新処理
            $input = $request->all();

            // バリデーションの実行
            $validator = Validator::make($input, HealthInfo::$rules, HealthInfo::$messages);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // 既存データを取得
            $health_info = HealthInfo::where('user_id', $input['id'])->first();

            if ($health_info) {
                // レコードが存在する場合は更新
                $health_info->update($input);
            } else {
                // レコードが存在しない場合は新規作成
                HealthInfo::create([
                    'user_id' => $input['id'], // user_id指定
                    'treating_disease' => $input['treating_disease'],
                    // 'carried_medications' => $input['carried_medications'],
                    'health_status_last_3_months' => $input['health_status_last_3_months'],
                    'recent_health_status' => $input['recent_health_status'],
                    'doctor_advice' => $input['doctor_advice'],
                    'medical_history' => $input['medical_history'],
                    'food_allergies' => $input['food_allergies'],
                    'allergen' => $input['allergen'],
                    'reaction_to_allergen' => $input['reaction_to_allergen'],
                    'usual_response_to_reaction' => $input['usual_response_to_reaction'],
                ]);
            }

            // DB保存
            // $health_info->save();

            // flash
            $name = Auth::user()->name;
            Flash::success($name . '健康情報を登録しました');

            return back();
        }
    }
}
