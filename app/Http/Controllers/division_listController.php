<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createdivision_listRequest;
use App\Http\Requests\Updatedivision_listRequest;
use App\Repositories\division_listRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class division_listController extends AppBaseController
{
    /** @var division_listRepository $divisionListRepository*/
    private $divisionListRepository;

    public function __construct(division_listRepository $divisionListRepo)
    {
        $this->divisionListRepository = $divisionListRepo;
    }

    /**
     * Display a listing of the division_list.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $divisionLists = $this->divisionListRepository->all();

        return view('division_lists.index')
            ->with('divisionLists', $divisionLists);
    }

    /**
     * Show the form for creating a new division_list.
     *
     * @return Response
     */
    public function create()
    {
        return view('division_lists.create');
    }

    /**
     * Store a newly created division_list in storage.
     *
     * @param Createdivision_listRequest $request
     *
     * @return Response
     */
    public function store(Createdivision_listRequest $request)
    {
        $input = $request->all();

        $divisionList = $this->divisionListRepository->create($input);

        Flash::success('Division List saved successfully.');

        return redirect(route('divisionLists.index'));
    }

    /**
     * Display the specified division_list.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $divisionList = $this->divisionListRepository->find($id);

        if (empty($divisionList)) {
            Flash::error('Division List not found');

            return redirect(route('divisionLists.index'));
        }

        return view('division_lists.show')->with('divisionList', $divisionList);
    }

    /**
     * Show the form for editing the specified division_list.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $divisionList = $this->divisionListRepository->find($id);

        if (empty($divisionList)) {
            Flash::error('Division List not found');

            return redirect(route('divisionLists.index'));
        }

        return view('division_lists.edit')->with('divisionList', $divisionList);
    }

    /**
     * Update the specified division_list in storage.
     *
     * @param int $id
     * @param Updatedivision_listRequest $request
     *
     * @return Response
     */
    public function update($id, Updatedivision_listRequest $request)
    {
        $divisionList = $this->divisionListRepository->find($id);

        if (empty($divisionList)) {
            Flash::error('Division List not found');

            return redirect(route('divisionLists.index'));
        }

        $divisionList = $this->divisionListRepository->update($request->all(), $id);

        Flash::success('課程別研修を更新しました');

        return redirect(route('divisionLists.index'));
    }

    /**
     * Remove the specified division_list from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $divisionList = $this->divisionListRepository->find($id);

        if (empty($divisionList)) {
            Flash::error('Division List not found');

            return redirect(route('divisionLists.index'));
        }

        $this->divisionListRepository->delete($id);

        Flash::success('課程別研修を削除しました');

        return redirect(route('divisionLists.index'));
    }
}
