<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AffiliatePayable;
use App\Models\CollectPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class CollectPaymentsController extends Controller
{


    public function index()
    {
        $collectPayments = CollectPayment::with('user')->paginate(25);

        return view('master.collect_payments.index', compact('collectPayments'));
    }


    public function create()
    {
        $users = User::pluck('name', 'id')->all();

        return view('master.collect_payments.create', compact('users', 'users'));
    }

    public function store(Request $request)
    {


        $data = $this->getData($request);

        $collectPayment = CollectPayment::create($data);
        $this->syncWithPayable($collectPayment);

        return redirect()->route('collect_payments.collect_payment.index')
            ->with('success_message', 'Collect Payment was successfully added.');

    }


    public function show($id)
    {
        $collectPayment = CollectPayment::with('user')->findOrFail($id);

        return view('master.collect_payments.show', compact('collectPayment'));
    }


    public function edit($id)
    {
        $collectPayment = CollectPayment::findOrFail($id);
        $users = User::pluck('name', 'id')->all();
//        dd($collectPayment->referred);
        return view('master.collect_payments.edit', compact('collectPayment', 'users', 'users'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $collectPayment = CollectPayment::findOrFail($id);
        $collectPayment->update($data);
        $this->syncWithPayable($collectPayment);

        return redirect()->route('collect_payments.collect_payment.index')
            ->with('success_message', 'Collect Payment was successfully updated.');

    }


    public function syncWithPayable(CollectPayment $payment)

    {
        AffiliatePayable::query()->where('type', get_class($payment))->where('type_id', $payment->id)->delete();

        AffiliatePayable::create([
            'date' => $payment->date,
            'amount' => $payment->referred_by_amount,
            'from_user' => $payment->user_id,
            'type' => get_class($payment),
            'type_id' => $payment->id,
        ]);

    }

    public function destroy($id)
    {

        $collectPayment = CollectPayment::findOrFail($id);
        AffiliatePayable::query()->where('type', get_class($collectPayment))->where('type_id', $collectPayment->id)->delete();
        $collectPayment->delete();
        return redirect()->route('collect_payments.collect_payment.index')
            ->with('success_message', 'Collect Payment was successfully deleted.');
    }


    protected function getData(Request $request)
    {
        $rules = [
            'date' => 'nullable|string|min:0',
            'for_month' => 'string|min:1|nullable',
            'user_id' => 'nullable',
            'amount' => 'string|min:1|nullable',
            'referred_by' => 'nullable',
            'referred_by_amount' => 'string|min:1|nullable',
            'note' => 'string|min:1|max:1000|nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
