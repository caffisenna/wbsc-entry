<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createcourse_listRequest;
use App\Http\Requests\Updatecourse_listRequest;
use App\Repositories\course_listRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class course_listController extends AppBaseController
{
    /** @var course_listRepository $courseListRepository*/
    private $courseListRepository;

    public function __construct(course_listRepository $courseListRepo)
    {
        $this->courseListRepository = $courseListRepo;
    }

    /**
     * Display a listing of the course_list.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $courseLists = $this->courseListRepository->all();

        return view('course_lists.index')
            ->with('courseLists', $courseLists);
    }

    /**
     * Show the form for creating a new course_list.
     *
     * @return Response
     */
    public function create()
    {
        return view('course_lists.create');
    }

    /**
     * Store a newly created course_list in storage.
     *
     * @param Createcourse_listRequest $request
     *
     * @return Response
     */
    public function store(Createcourse_listRequest $request)
    {
        $input = $request->all();

        $courseList = $this->courseListRepository->create($input);

        Flash::success('コース情報を登録しました');

        return redirect(route('courseLists.index'));
    }

    /**
     * Display the specified course_list.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $courseList = $this->courseListRepository->find($id);

        if (empty($courseList)) {
            Flash::error('Course List not found');

            return redirect(route('courseLists.index'));
        }

        return view('course_lists.show')->with('courseList', $courseList);
    }

    /**
     * Show the form for editing the specified course_list.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $courseList = $this->courseListRepository->find($id);

        if (empty($courseList)) {
            Flash::error('Course List not found');

            return redirect(route('courseLists.index'));
        }

        return view('course_lists.edit')->with('courseList', $courseList);
    }

    /**
     * Update the specified course_list in storage.
     *
     * @param int $id
     * @param Updatecourse_listRequest $request
     *
     * @return Response
     */
    public function update($id, Updatecourse_listRequest $request)
    {
        $courseList = $this->courseListRepository->find($id);

        if (empty($courseList)) {
            Flash::error('Course List not found');

            return redirect(route('courseLists.index'));
        }

        $courseList = $this->courseListRepository->update($request->all(), $id);

        Flash::success('コース情報を更新しました');

        return redirect(route('courseLists.index'));
    }

    /**
     * Remove the specified course_list from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $courseList = $this->courseListRepository->find($id);

        if (empty($courseList)) {
            Flash::error('Course List not found');

            return redirect(route('courseLists.index'));
        }

        $this->courseListRepository->delete($id);

        Flash::success('コース情報を削除しました');

        return redirect(route('courseLists.index'));
    }
}
