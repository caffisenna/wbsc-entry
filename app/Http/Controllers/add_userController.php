<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createadd_userRequest;
use App\Http\Requests\Updateadd_userRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\add_user;
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
        // $addUsers = User::where('is_admin',  1)
        //     ->orWhere('is_ais', '<>', null)
        //     ->orWhere('is_commi', '<>', null)
        //     ->orWhere('is_course_staff', '<>', null)
        //     ->get();
        $addUsers = User::get();

        foreach ($addUsers as $user) {
            if ($user->is_admin == 1) {
                $user->role = "管理者";
            } elseif ($user->is_ais !== null) {
                $user->role = "AIS " . $user->is_ais;
            } elseif ($user->is_commi !== null) {
                $user->role = "地区コミ " . $user->is_commi;
            }elseif ($user->is_course_staff !== null) {
                $user->role = "コーススタッフ " . $user->is_course_staff;
            }else{
                $user->role = "参加者";
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
        // $user = new User();

        // 権限セット
        if ($input['role'] == 'admin') {
            $input['is_admin']  = 1;
            $input['is_ais'] = null;
            $input['is_commi'] = null;
            $input['is_course_staff'] = null;
        } elseif ($input['role'] == 'AIS') {
            $input['is_admin']  = 1;
            $input['is_ais'] = $input['district'];
            $input['is_commi'] = null;
            $input['is_course_staff'] = null;
        } elseif ($input['role'] == 'commi') {
            $input['is_admin']  = 0;
            $input['is_ais']  = null;
            $input['is_commi'] = $input['district'];
            $input['is_course_staff'] = null;
        } elseif ($input['role'] == 'course_staff') {
            $input['is_admin']  = 0;
            $input['is_ais']  = null;
            $input['is_commi'] = null;
            $input['is_course_staff'] = $input['course_staff'];
        }
        // メール認証を'済み'にセット
        $input['email_verified_at'] = now();

        $user = User::create($input);

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
        // $addUser = $this->addUserRepository->find($id);

        // if (empty($addUser)) {
        //     Flash::error('Add User not found');

        //     return redirect(route('addUsers.index'));
        // }

        // $addUser = $this->addUserRepository->update($request->all(), $id);
        $input = $request->all();
        $user = User::where('id',$id)->first();
        $user->update($input);

        Flash::success('ユーザー情報を更新しました');

        return redirect(route('add_users.index'));
    }

    /**
     * Remove the specified add_user from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('対象が見つかりません');

            return redirect(route('add_users.index'));
        }

        $user->delete($id);

        Flash::success($user->name . ' のアカウントを削除しました');

        return redirect(route('add_users.index'));
    }

    public function pass_reset(Request $request)
    {
        //  id判定でリダイレクト
        if (isset($request->id)) {
            $id = $request->id;
            $user = User::find($id);
            if (empty($user)) {
                Flash::error('対象が見つかりません');

                return redirect(route('add_users.index'));
            }
        } else {
            Flash::error('対象が見つかりません');
            return redirect(route('add_users.index'));
        }

        // ここでリセット処理か判定する
        if ($request['confirm'] == 'true') {
            // ここにリセット処理を書く
            $user->password = bcrypt($request['new_password']);
            $user->save();

            Flash::success($user->name . ' のパスワードを更新しました');
            return redirect(route('add_users.index'));
        } else {
            // create new password
            $length = 8;
            $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $new_password = '';

            for ($i = 0; $i < $length; $i++) {
                $index = random_int(0, strlen($characters) - 1);
                $new_password .= $characters[$index];
            }
            $user->new_password = $new_password;
            return view('add_users.password_reset')->with('user', $user);
        }
    }
}
