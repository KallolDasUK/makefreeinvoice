<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Exception;
use Illuminate\Http\Request;

class TaxesController extends Controller
{


    public function index()
    {
        $taxes = Tax::query()->latest()->get();

        return view('taxes.index', compact('taxes'));
    }


    public function create()
    {


        return view('taxes.create');
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        $tax = Tax::create($data);

        // sleep(5);

        if ($request->acceptsJson()) {
            return $tax;
        }
        return redirect()->route('taxes.tax.index')
            ->with('success_message', 'Tax was successfully added.');

    }


    public function show($id)
    {
        $tax = Tax::findOrFail($id);

        return view('taxes.show', compact('tax'));
    }


    public function edit($id)
    {
        $tax = Tax::findOrFail($id);


        return view('taxes.edit', compact('tax'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $tax = Tax::findOrFail($id);
        $tax->update($data);

        return redirect()->route('taxes.tax.index')
            ->with('success_message', 'Tax was successfully updated.');

    }


    public function destroy($id)
    {
        try {
            $tax = Tax::findOrFail($id);
            $tax->delete();

            return redirect()->route('taxes.tax.index')
                ->with('success_message', 'Tax was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }


    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'required|nullable|string|min:1|max:255',
            'value' => 'required|nullable|string|min:1',
            'tax_type' => 'nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
