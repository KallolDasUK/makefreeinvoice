<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class PaymentRequestsController extends Controller
{

    public function index()
    {
        $paymentRequests = PaymentRequest::with('user')->paginate(25);

        return view('master.payment_requests.index', compact('paymentRequests'));
    }


    public function create()
    {
        $users = User::pluck('name', 'id')->all();

        return view('master.payment_requests.create', compact('users'));
    }

    public function store(Request $request)
    {


        $data = $this->getData($request);

        PaymentRequest::create($data);

        return redirect()->route('payment_requests.payment_request.index')
            ->with('success_message', 'Payment Request was successfully added.');

    }


    public function show($id)
    {
        $paymentRequest = PaymentRequest::with('user')->findOrFail($id);

        return view('master.payment_requests.show', compact('paymentRequest'));
    }


    public function edit($id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);
        $users = User::pluck('name', 'id')->all();

        return view('master.payment_requests.edit', compact('paymentRequest', 'users'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $paymentRequest = PaymentRequest::findOrFail($id);
        $paymentRequest->update($data);

        return redirect()->route('payment_requests.payment_request.index')
            ->with('success_message', 'Payment Request was successfully updated.');

    }


    public function destroy($id)
    {

        $paymentRequest = PaymentRequest::findOrFail($id);
        $paymentRequest->delete();

        return redirect()->route('payment_requests.payment_request.index')
            ->with('success_message', 'Payment Request was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'date' => 'required',
            'user_id' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'note' => 'string|min:1|max:1000|nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
