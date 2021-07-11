<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class CustomersController extends Controller
{


    public function index()
    {
        $customers = Customer::query()->latest()->get();

        return view('customers.index', compact('customers'));
    }


    public function create()
    {


        return view('customers.create');
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        $customer = Customer::create($data);
        if ($request->acceptsJson()) {
            return $customer;
        }

        return redirect()->route('customers.customer.index')
            ->with('success_message', 'Customer was successfully added.');

    }


    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return view('customers.show', compact('customer'));
    }


    public function edit($id)
    {
        $customer = Customer::findOrFail($id);


        return view('customers.edit', compact('customer'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $customer = Customer::findOrFail($id);
        $customer->update($data);

        return redirect()->route('customers.customer.index')
            ->with('success_message', 'Customer was successfully updated.');

    }


    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            return redirect()->route('customers.customer.index')
                ->with('success_message', 'Customer was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }


    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'required|nullable|string|min:1|max:255',
            'photo' => ['file', 'nullable'],
            'company_name' => 'string|min:1|nullable',
            'phone' => 'string|min:1|nullable',
            'email' => 'nullable',
            'address' => 'string|min:1|nullable',
            'website' => 'string|min:1|nullable',
        ];

        $data = $request->validate($rules);
        if ($request->has('custom_delete_photo')) {
            $data['photo'] = null;
        }
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->moveFile($request->file('photo'));
        }

        return $data;
    }


    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }


        $path = config('laravel-code-generator.files_upload_path', 'uploads');
        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }
}
