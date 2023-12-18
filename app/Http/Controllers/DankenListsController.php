<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDankenListsRequest;
use App\Http\Requests\UpdateDankenListsRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DankenListsRepository;
use Illuminate\Http\Request;
use Flash;

class DankenListsController extends AppBaseController
{
    /** @var DankenListsRepository $dankenListsRepository*/
    private $dankenListsRepository;

    public function __construct(DankenListsRepository $dankenListsRepo)
    {
        $this->dankenListsRepository = $dankenListsRepo;
    }

    /**
     * Display a listing of the DankenLists.
     */
    public function index(Request $request)
    {
        $dankenLists = $this->dankenListsRepository->all();

        return view('danken_lists.index')
            ->with(compact('dankenLists'));
    }

    /**
     * Show the form for creating a new DankenLists.
     */
    public function create()
    {
        return view('danken_lists.create');
    }

    /**
     * Store a newly created DankenLists in storage.
     */
    public function store(CreateDankenListsRequest $request)
    {
        $input = $request->all();

        $dankenLists = $this->dankenListsRepository->create($input);

        Flash::success('団研の情報を登録しました');

        return redirect(route('dankenLists.index'));
    }

    /**
     * Display the specified DankenLists.
     */
    public function show($id)
    {
        $dankenLists = $this->dankenListsRepository->find($id);

        if (empty($dankenLists)) {
            Flash::error('Danken Lists not found');

            return redirect(route('dankenLists.index'));
        }

        return view('danken_lists.show')->with('dankenLists', $dankenLists);
    }

    /**
     * Show the form for editing the specified DankenLists.
     */
    public function edit($id)
    {
        $dankenLists = $this->dankenListsRepository->find($id);

        if (empty($dankenLists)) {
            Flash::error('Danken Lists not found');

            return redirect(route('dankenLists.index'));
        }

        return view('danken_lists.edit')->with('dankenLists', $dankenLists);
    }

    /**
     * Update the specified DankenLists in storage.
     */
    public function update($id, UpdateDankenListsRequest $request)
    {
        $dankenLists = $this->dankenListsRepository->find($id);

        if (empty($dankenLists)) {
            Flash::error('Danken Lists not found');

            return redirect(route('dankenLists.index'));
        }

        $dankenLists = $this->dankenListsRepository->update($request->all(), $id);

        Flash::success('団研のデータを更新しました');

        return redirect(route('dankenLists.index'));
    }

    /**
     * Remove the specified DankenLists from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $dankenLists = $this->dankenListsRepository->find($id);

        if (empty($dankenLists)) {
            Flash::error('Danken Lists not found');

            return redirect(route('dankenLists.index'));
        }

        $this->dankenListsRepository->delete($id);

        Flash::success('団研のデータを削除しました。');

        return redirect(route('dankenLists.index'));
    }
}
