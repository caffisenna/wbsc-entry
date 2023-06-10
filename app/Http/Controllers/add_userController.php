<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createadd_userRequest;
use App\Http\Requests\Updateadd_userRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\add_userRepository;
use Illuminate\Http\Request;
use Flash;
use App\Models\User;

class add_userController extends AppBaseController
{
    /** @var add_userRepository $addUserRepository*/
    private $addUserRepository;

    public function __construct(add_userRepository $addUserRepo)
    {
        $this->addUserRepository = $addUserRepo;
    }

    /**
     * Display a listing of the add_user.
     */
    public function index(Request $request)
    {
        // $addUsers = $this->addUserRepository->paginate(10);
        $addUsers = User::where('is_admin',  1)
            ->orWhere('is_staff', '<>', null)
            ->orWhere('is_commi', '<>', null)
            ->get();

        foreach ($addUsers as $user) {
            if ($user->is_admin == 1) {
                $user->role = "管理者";
            } elseif ($user->is_staff !== null) {
                $user->role = "AIS " . $user->is_staff;
            } elseif ($user->is_commi !== null) {
                $user->role = "地区コミ " . $user->is_commi;
            }
        }

        return view('add_users.index')
            ->with('addUsers', $addUsers);
    }

    /**
     * Show the form for creating a new add_user.
     */
    public function create()
    {
        return view('add_users.create');
    }

    /**
     * Store a newly created add_user in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = new User();


        // 権限
        if ($input['role'] == 'admin') {
            $user->is_admin  = 1;
            $input['district'] = null;
        } elseif ($input['role'] == 'AIS') {
            $input['is_staff'] = $input['district'];
        } elseif ($input['role'] == 'commi') {
            $input['is_commi'] = $input['district'];
        }


        $user = User::create($input);
        $user->save();

        Flash::success('アカウントを作成しました。対象者に通知をしてください。');

        return redirect(route('add_users.index'));
    }

    /**
     * Display the specified add_user.
     */
    public function show($id)
    {
        $addUser = $this->addUserRepository->find($id);

        if (empty($addUser)) {
            Flash::error('Add User not found');

            return redirect(route('addUsers.index'));
        }

        return view('add_users.show')->with('addUser', $addUser);
    }

    /**
     * Show the form for editing the specified add_user.
     */
    public function edit($id)
    {
        $addUser = User::find($id);

        if (empty($addUser)) {
            Flash::error('Add User not found');

            return redirect(route('add_users.index'));
        }

        return view('add_users.edit')->with('addUser', $addUser);
    }

    /**
     * Update the specified add_user in storage.
     */
    public function update($id, Updateadd_userRequest $request)
    {
        $addUser = $this->addUserRepository->find($id);

        if (empty($addUser)) {
            Flash::error('Add User not found');

            return redirect(route('addUsers.index'));
        }

        $addUser = $this->addUserRepository->update($request->all(), $id);

        Flash::success('Add User updated successfully.');

        return redirect(route('addUsers.index'));
    }

    /**
     * Remove the specified add_user from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $addUser = $this->addUserRepository->find($id);

        if (empty($addUser)) {
            Flash::error('Add User not found');

            return redirect(route('addUsers.index'));
        }

        $this->addUserRepository->delete($id);

        Flash::success('Add User deleted successfully.');

        return redirect(route('addUsers.index'));
    }
}
