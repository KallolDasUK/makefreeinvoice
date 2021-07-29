<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Exception;

class PaymentMethodsController extends Controller
{


    public function index()
    {
        $paymentMethods = PaymentMethod::paginate(25);

        return view('payment_methods.index', compact('paymentMethods'));
    }

    public function create()
    {


        return view('payment_methods.create');
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        $payment = PaymentMethod::create($data);
        if ($request->ajax()) {
            return $payment;
        }

        return redirect()->route('payment_methods.payment_method.index')
            ->with('success_message', 'Payment Method was successfully added.');

    }

    public function show($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        return view('payment_methods.show', compact('paymentMethod'));
    }


    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);


        return view('payment_methods.edit', compact('paymentMethod'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->update($data);

        return redirect()->route('payment_methods.payment_method.index')
            ->with('success_message', 'Payment Method was successfully updated.');

    }


    public function destroy($id)
    {

        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();

        return redirect()->route('payment_methods.payment_method.index')
            ->with('success_message', 'Payment Method was successfully deleted.');

    }


    protected function getData(Request $request)
    {

        $rules = [
            'name' => 'required|string|min:1|max:255',
            'is_default' => 'nullable',
            'description' => 'nullable|string|min:0|max:255',
        ];

        $data = $request->validate($rules);
        $data['is_default'] = $request->has('is_default');
        if ($request->has('is_default')) {
            PaymentMethod::query()->update(['is_default' => false]);
        }
//        dd($data);
        return $data;
    }

}
