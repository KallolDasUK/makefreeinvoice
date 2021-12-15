<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Exception;

class UserNotificationsController extends Controller
{


    public function index()
    {
        $userNotifications = UserNotification::with('user')->paginate(25);

        return view('user_notifications.index', compact('userNotifications'));
    }


    public function create()
    {
        $users = User::all();

        return view('user_notifications.create', compact('users'));
    }

    public function markSeen()
    {
        UserNotification::query()->where('user_id', auth()->id())->update(['seen' => true]);
        return [];
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        UserNotification::create($data);

        return redirect()->route('user_notifications.user_notification.index')
            ->with('success_message', 'User Notification was successfully added.');

    }


    public function show($id)
    {
        $userNotification = UserNotification::with('user')->findOrFail($id);

        return view('user_notifications.show', compact('userNotification'));
    }


    public function edit($id)
    {
        $userNotification = UserNotification::findOrFail($id);
        $users = User::all();

        return view('user_notifications.edit', compact('userNotification', 'users'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $userNotification = UserNotification::findOrFail($id);
        $userNotification->update($data);

        return redirect()->route('user_notifications.user_notification.index')
            ->with('success_message', 'User Notification was successfully updated.');

    }


    public function destroy($id)
    {

        $userNotification = UserNotification::findOrFail($id);
        $userNotification->delete();

        return redirect()->route('user_notifications.user_notification.index')
            ->with('success_message', 'User Notification was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'type' => 'required|nullable',
            'title' => 'required|nullable|string|min:1|max:255',
            'body' => 'required|nullable|string|min:1',
            'user_id' => 'nullable',
            'seen' => 'nullable|array',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
