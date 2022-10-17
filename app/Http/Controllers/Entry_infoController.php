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
        return view('entry_infos.create');
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

        if (empty($entryInfo)) {
            Flash::error('Entry Info not found');

            return redirect(route('entryInfos.index'));
        }

        return view('entry_infos.edit')->with('entryInfo', $entryInfo);
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
        $entryInfo = User::where('id',Auth::id())->with('entry_info')->first();
        // $entryInfo = Entry_info::where('user_id',Auth::id())->with('user')->first();
        // dd($entryInfo);

        $pdf = \PDF::loadView('entry_infos.pdf', compact('entryInfo',$entryInfo));
        $pdf->setPaper('A4');
        // return $pdf->download();
        return $pdf->stream();
    }
}
