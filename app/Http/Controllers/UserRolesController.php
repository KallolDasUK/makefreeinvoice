<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Exception;

class UserRolesController extends Controller
{


    public function index()
    {
        view()->share('title', 'User Roles');
        $userRoles = UserRole::paginate(25);

        return view('user_roles.index', compact('userRoles'));
    }


    public function create()
    {

        view()->share('title', 'Create Role');


        $features = [];


        foreach (app_features() as $code => $name) {
            $features[] = (object)['name' => $name, 'code' => $code, 'create' => false, 'read' => false, 'edit' => false, 'delete' => false];
        }
        $features = (object)$features;
        return view('user_roles.create', compact('features'));
    }


    public function store(Request $request)
    {

        $features = [];
        $data = $this->getData($request);
        $codes = ['invoice', 'estimate', 'bill', 'pos', 'product'];
//        dd($request->all());


        foreach (app_features() as $code => $name) {
            $features[$code]['create'] = boolval($request->create[$code]);
            $features[$code]['read'] = boolval($request->read[$code]);
            $features[$code]['edit'] = boolval($request->edit[$code]);
            $features[$code]['delete'] = boolval($request->delete[$code]);
        }


//        dd($features);
        $data['payload'] = json_encode($features);

        UserRole::create($data);


        return redirect()->route('user_roles.user_role.index')
            ->with('success_message', 'User Role was successfully added.');

    }


    public function show($id)
    {
        $userRole = UserRole::findOrFail($id);

        return view('user_roles.show', compact('userRole'));
    }


    public function edit($id)
    {
        $userRole = UserRole::findOrFail($id);
        $payload = $userRole->payload;
        $payload = json_decode($payload, true);
//        dd($payload);
        $features = [];
        foreach (app_features() as $code => $name) {
            $create = $delete = $read = $edit = false;
            try {
                $create = $payload[$code]['create'];
            } catch (\Exception $exception) {

            }
            try {
                $delete = $payload[$code]['delete'];
            } catch (\Exception $exception) {

            }
            try {
                $read = $payload[$code]['read'];
            } catch (\Exception $exception) {

            }
            try {
                $edit = $payload[$code]['edit'];
            } catch (\Exception $exception) {

            }
            $features[] = (object)['name' => $name, 'code' => $code, 'create' => $create, 'read' => $read, 'edit' => $edit, 'delete' => $edit];
        }
//        dd($features);
        return view('user_roles.edit', compact('userRole', 'features'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);
        $userRole = UserRole::findOrFail($id);
        $userRole->update($data);

        return redirect()->route('user_roles.user_role.index')
            ->with('success_message', 'User Role was successfully updated.');

    }


    public function destroy($id)
    {

        $userRole = UserRole::findOrFail($id);
        $userRole->delete();

        return redirect()->route('user_roles.user_role.index')
            ->with('success_message', 'User Role was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'required|nullable|string|min:1|max:255',
            'description' => 'string|min:1|max:1000|nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
