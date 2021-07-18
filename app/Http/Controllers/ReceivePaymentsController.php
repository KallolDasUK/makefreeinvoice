<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\ReceivePayment;
use Illuminate\Http\Request;
use Exception;

class ReceivePaymentsController extends Controller
{


    public function index()
    {
        $receivePayments = ReceivePayment::with('customer','paymentmethod')->paginate(25);

        return view('receive_payments.index', compact('receivePayments'));
    }


    public function create()
    {
        $customers = Customer::pluck('name','id')->all();
        $paymentMethods = PaymentMethod::pluck('name','id')->all();

        return view('receive_payments.create', compact('customers','paymentMethods'));
    }


    public function store(Request $request)
    {


            $data = $this->getData($request);

            ReceivePayment::create($data);

            return redirect()->route('receive_payments.receive_payment.index')
                ->with('success_message', 'Receive Payment was successfully added.');

    }


    public function show($id)
    {
        $receivePayment = ReceivePayment::with('customer','paymentmethod')->findOrFail($id);

        return view('receive_payments.show', compact('receivePayment'));
    }


    public function edit($id)
    {
        $receivePayment = ReceivePayment::findOrFail($id);
        $customers = Customer::pluck('name','id')->all();
        $paymentMethods = PaymentMethod::pluck('name','id')->all();

        return view('receive_payments.edit', compact('receivePayment','customers','paymentMethods'));
    }


    public function update($id, Request $request)
    {


            $data = $this->getData($request);

            $receivePayment = ReceivePayment::findOrFail($id);
            $receivePayment->update($data);

            return redirect()->route('receive_payments.receive_payment.index')
                ->with('success_message', 'Receive Payment was successfully updated.');

    }


    public function destroy($id)
    {

            $receivePayment = ReceivePayment::findOrFail($id);
            $receivePayment->delete();

            return redirect()->route('receive_payments.receive_payment.index')
                ->with('success_message', 'Receive Payment was successfully deleted.');

    }



    protected function getData(Request $request)
    {
        $rules = [
                'customer_id' => 'required|nullable',
            'payment_date' => 'required|nullable|date_format:j/n/Y',
            'payment_sl' => 'unique|nullable|string|min:0',
            'payment_method_id' => 'nullable',
            'deposit_to' => 'required|nullable',
            'note' => 'string|min:1|max:1000|nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
