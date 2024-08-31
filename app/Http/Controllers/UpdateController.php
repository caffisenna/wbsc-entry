<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateRequest;
use App\Http\Requests\UpdateUpdateRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Update;
use App\Repositories\UpdateRepository;
use Illuminate\Http\Request;
use Flash;
use Auth;

class UpdateController extends AppBaseController
{
    /** @var UpdateRepository $updateRepository*/
    private $updateRepository;

    public function __construct(UpdateRepository $updateRepo)
    {
        $this->updateRepository = $updateRepo;
    }

    /**
     * Display a listing of the Update.
     */
    public function index(Request $request)
    {
        // $updates = $this->updateRepository->paginate(10);
        $updates = Update::orderby('created_at', 'desc')->paginate(10);
        // dd($updates);

        return view('updates.index')
            ->with(compact('updates'));
    }

    /**
     * Show the form for creating a new Update.
     */
    public function create()
    {
        if (Auth::user()->is_admin == 1 && empty(Auth::user()->is_ais)) {
            // 純粋な管理種のみ作成画面へ
            return view('updates.create');
        } else {
            // その他の場合はredirect
            return back();
        }
    }

    /**
     * Store a newly created Update in storage.
     */
    public function store(CreateUpdateRequest $request)
    {
        $input = $request->all();

        $update = $this->updateRepository->create($input);

        Flash::success('お知らせを登録しました');

        return redirect(route('updates.index'));
    }

    /**
     * Show the form for editing the specified Update.
     */
    public function edit($id)
    {
        if (Auth::user()->is_admin == 1 && empty(Auth::user()->is_ais)) {
            $update = $this->updateRepository->find($id);

            if (empty($update)) {
                Flash::error('Update not found');

                return redirect(route('updates.index'));
            }

            return view('updates.edit')->with('update', $update);
        } else {
            return back();
        }
    }

    /**
     * Update the specified Update in storage.
     */
    public function update($id, UpdateUpdateRequest $request)
    {
        $update = $this->updateRepository->find($id);

        if (empty($update)) {
            Flash::error('Update not found');

            return redirect(route('updates.index'));
        }

        $update = $this->updateRepository->update($request->all(), $id);

        Flash::success('お知らせを更新しました');

        return redirect(route('updates.index'));
    }

    /**
     * Remove the specified Update from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $update = $this->updateRepository->find($id);

        if (empty($update)) {
            Flash::error('Update not found');

            return redirect(route('updates.index'));
        }

        $this->updateRepository->delete($id);

        Flash::success('お知らせを削除しました');

        return redirect(route('updates.index'));
    }
}
