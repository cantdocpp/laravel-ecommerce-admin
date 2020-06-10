<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function index(Request $request) {
        $role = $request->query('role');
        if ($role) {
            $users = User::where('role', '=', $role)->paginate(15);
        } else {
            $users = User::paginate(15);
        }
        return view('admin.users.user', [
            'users' => $users->appends(request()->query())
        ]);
    }

    public function create() {
        return view('admin.users.userCreate');
    }

    public function store(Request $request) {
        $validateData = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'password' => 'required|min:6',
            'confirm' => 'same:password|min:6',
            'role' => 'required'
        ]);

        if ($validateData->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($validateData)
                    ->withInput();
        }

        /*
            $request->all() = 
            [
                "_token" => "w20TUSDav82Ke4Kem7arbzQmwj7B7TM9pv3sz1x6"
                "name" => null
                "email" => null
                "phone" => null
                "password" => null
                "confirm" => null
                "role" => null
            ]
        */
        $userData = $request->only('name', 'email', 'phone', 'role');
        $userData['password'] = Hash::make($request->password);
        $user = User::create($userData);
        $user->save();

        return redirect(route('admin.users'));
    }

    public function destroy(Request $request, User $user) {
        $user->delete();
        return 'success';
    }

    public function bulkDestroy(Request $request) {
        $userIdArray = $request->user;
        User::destroy($userIdArray);
        return 'success';
    }
}
