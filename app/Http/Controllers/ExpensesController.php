<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseItem;
use App\Models\Tax;
use App\Models\Vendor;
use Carbon\Carbon;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Illuminate\Http\Request;
use Exception;

class ExpensesController extends Controller
{

    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $q = $request->q;
        $expenses = Expense::with('ledger', 'vendor', 'customer')
            ->when($q != null, function ($query) use ($q) {
                return $query->where('ref', 'like', '%' . $q . '%');
            })->when($start_date != null && $end_date != null, function ($query) use ($start_date, $end_date) {
                $start_date = Carbon::parse($start_date)->toDateString();
                $end_date = Carbon::parse($end_date)->toDateString();
                return $query->whereBetween('date', [$start_date, $end_date]);
            })
            ->latest();
//        dd($expenses->get()->sum('amount'));
        $totalExpense = $expenses->get()->sum('amount');
        $expenses = $expenses->paginate(10);
        return view('expenses.index', compact('expenses', 'start_date', 'end_date', 'q', 'totalExpense'));
    }


    public function create()
    {
        $ledgers = Ledger::query()->get();
        $ledgerGroups = LedgerGroup::query()->get();

        $vendors = Vendor::pluck('name', 'id')->all();
        $customers = Customer::pluck('name', 'id')->all();
        $taxes = Tax::query()->latest()->get()->toArray();
        return view('expenses.create', compact('ledgers', 'vendors', 'customers', 'taxes', 'ledgerGroups'));
    }

    public function store(Request $request)
    {


        $data = $this->getData($request);

        $expense_items = $data['expense_items'];
        unset($data['expense_items']);
        $expense = Expense::create($data);
        foreach ($expense_items as $expense_item) {
            ExpenseItem::create($expense_item + ['expense_id' => $expense->id, 'date' => $request->date ?? null]);
        }

        return redirect()->route('expenses.expense.show', $expense->id)
            ->with('success_message', 'Expense was successfully added.');

    }

    public function show($id)
    {
        $expense = Expense::with('ledger', 'vendor', 'customer')->findOrFail($id);
        $is_print = intval(request('print', 0));
        $is_download = intval(request('download', 0));
//        dd($is_print);
        return view('expenses.show', compact('expense', 'is_download', 'is_print'));
    }


    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $ledgers = Ledger::query()->get();
        $vendors = Vendor::pluck('name', 'id')->all();
        $customers = Customer::pluck('name', 'id')->all();
        $expense_items = ExpenseItem::query()->where('expense_id', $expense->id)->get();
        $taxes = Tax::query()->latest()->get()->toArray();
//        dd($expense_items);
        return view('expenses.edit', compact('expense', 'ledgers', 'vendors', 'customers', 'expense_items', 'taxes'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);
        $expense_items = $data['expense_items'];
        unset($data['expense_items']);
        $expense = Expense::findOrFail($id);
        ExpenseItem::query()->where('expense_id', $expense->id)->get()->each(function ($model) {
            $model->delete();
        });
        $expense->update($data);
        foreach ($expense_items as $expense_item) {
            ExpenseItem::create($expense_item + ['expense_id' => $expense->id, 'date' => $request->date ?? null]);
        }


        return redirect()->route('expenses.expense.index')
            ->with('success_message', 'Expense was successfully updated.');

    }


    public function destroy($id)
    {

        $expense = Expense::findOrFail($id);
        ExpenseItem::query()->where('expense_id', $id)->get()->each(function ($model) {
            $model->delete();
        });;
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
            'expense_items' => 'nullable',
            'file' => ['file', 'nullable'],
        ];

        $data = $request->validate($rules);

        $data['expense_items'] = json_decode($data['expense_items'] ?? '{}', true);
//        dd($data);
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
