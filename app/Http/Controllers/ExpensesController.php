<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Vendor;
use Enam\Acc\Models\Ledger;
use Illuminate\Http\Request;
use Exception;

class ExpensesController extends Controller
{

    public function index()
    {
        $expenses = Expense::with('ledger', 'vendor', 'customer')->paginate(25);

        return view('expenses.index', compact('expenses'));
    }


    public function create()
    {
        $ledgers = Ledger::pluck('ledger_name', 'id')->all();
        $vendors = Vendor::pluck('name', 'id')->all();
        $customers = Customer::pluck('name', 'id')->all();

        return view('expenses.create', compact('ledgers', 'vendors', 'customers'));
    }

    public function store(Request $request)
    {


        $data = $this->getData($request);

        Expense::create($data);

        return redirect()->route('expenses.expense.index')
            ->with('success_message', 'Expense was successfully added.');

    }


    public function show($id)
    {
        $expense = Expense::with('ledger', 'vendor', 'customer')->findOrFail($id);

        return view('expenses.show', compact('expense'));
    }


    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $ledgers = Ledger::pluck('id', 'id')->all();
        $vendors = Vendor::pluck('name', 'id')->all();
        $customers = Customer::pluck('name', 'id')->all();

        return view('expenses.edit', compact('expense', 'ledgers', 'vendors', 'customers'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $expense = Expense::findOrFail($id);
        $expense->update($data);

        return redirect()->route('expenses.expense.index')
            ->with('success_message', 'Expense was successfully updated.');

    }


    public function destroy($id)
    {

        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('expenses.expense.index')
            ->with('success_message', 'Expense was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'date' => 'required|nullable|string|min:1',
            'ledger_id' => 'nullable',
            'vendor_id' => 'nullable',
            'customer_id' => 'nullable',
            'ref' => 'string|min:1|nullable',
            'is_billable' => 'boolean|nullable',
            'file' => ['file', 'nullable'],
        ];

        $data = $request->validate($rules);
        if ($request->has('custom_delete_file')) {
            $data['file'] = null;
        }
        if ($request->hasFile('file')) {
            $data['file'] = $this->moveFile($request->file('file'));
        }

        $data['is_billable'] = $request->has('is_billable');

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
