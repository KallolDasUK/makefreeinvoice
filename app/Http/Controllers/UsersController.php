<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index()
    {
        view()->share('title', 'User Settings');
        $users = User::query()
            ->with('user_role')
            ->where('id', '!=', auth()->id())
            ->where('role_id', '!=', null)
            ->where('client_id', auth()->user()->client_id)
            ->latest()
            ->paginate(25);
//        dd($users);
        return view('users.index', compact('users'));
    }


    public function create()
    {
        $roles = UserRole::all();

        view()->share('title', 'New User');

        return view('users.create', compact('roles'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        $user = User::create($data);
        $this->assign_permissions($user);

        return redirect()->route('users.user.index')
            ->with('success_message', 'User was successfully added.');

    }

    public function assign_permissions($user)
    {
        $permissions = $user->roles_permission;
        $user->syncPermissions($permissions);
//        dd($user->getAllPermissions());

    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }


    public function edit($id)
    {
        view()->share('title', 'Edit User');

        $user = User::findOrFail($id);
        $roles = UserRole::all();;
        return view('users.edit', compact('user', 'roles'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request, $id);

        $user = User::findOrFail($id);
        $user->update($data);
        $this->assign_permissions($user);

        return redirect()->route('users.user.index')
            ->with('success_message', 'User was successfully updated.');

    }


    public function destroy($id)
    {

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.user.index')
            ->with('success_message', 'User was successfully deleted.');

    }


    protected function getData(Request $request, $id = null)
    {
        $rules = [
            'name' => 'required|string|min:1|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role_id' => 'required',
        ];
        if ($id) {
            $rules['email'] = 'required|email|unique:users,email,' . $id;
        }
        $data = $request->validate($rules);
        $data['password'] = Hash::make($data['password']);
        $data['client_id'] = auth()->user()->client_id;

        return $data;
    }

}
