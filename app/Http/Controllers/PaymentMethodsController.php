<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Exception;

class PaymentMethodsController extends Controller
{

    /**
     * Display a listing of the payment methods.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::paginate(25);

        return view('payment_methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new payment method.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        

        return view('payment_methods.create');
    }

    /**
     * Store a new payment method in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

            
            $data = $this->getData($request);
            
            PaymentMethod::create($data);

            return redirect()->route('payment_methods.payment_method.index')
                ->with('success_message', 'Payment Method was successfully added.');

    }

    /**
     * Display the specified payment method.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        return view('payment_methods.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified payment method.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        

        return view('payment_methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified payment method in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

            
            $data = $this->getData($request);
            
            $paymentMethod = PaymentMethod::findOrFail($id);
            $paymentMethod->update($data);

            return redirect()->route('payment_methods.payment_method.index')
                ->with('success_message', 'Payment Method was successfully updated.');

    }

    /**
     * Remove the specified payment method from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $paymentMethod = PaymentMethod::findOrFail($id);
            $paymentMethod->delete();

            return redirect()->route('payment_methods.payment_method.index')
                ->with('success_message', 'Payment Method was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'name' => 'required|string|min:1|max:255',
            'is_default' => 'boolean|nullable',
            'description' => 'nullable|string|min:0|max:255', 
        ];
        
        $data = $request->validate($rules);

        $data['is_default'] = $request->has('is_default');

        return $data;
    }

}
