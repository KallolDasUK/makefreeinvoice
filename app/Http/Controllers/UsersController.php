<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index()
    {
        view()->share('title', 'User Settings');
        $users = User::query()
            ->where('id', '!=', auth()->id())
            ->where('client_id', auth()->user()->client_id)
            ->paginate(25);

        return view('users.index', compact('users'));
    }


    public function create()
    {

        view()->share('title', 'New User');

        return view('users.create');
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        User::create($data);

        return redirect()->route('users.user.index')
            ->with('success_message', 'User was successfully added.');

    }


    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request, $id);

        $user = User::findOrFail($id);
        $user->update($data);

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
