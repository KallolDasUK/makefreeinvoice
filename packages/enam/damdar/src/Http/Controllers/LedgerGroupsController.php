<?php

namespace Enam\Acc\Http\Controllers;

use Enam\Acc\Http\Controllers\Controller;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Illuminate\Http\Request;
use Enam\Acc\Utils\LedgerHelper;
use Exception;
use Illuminate\Support\Facades\View;

class LedgerGroupsController extends Controller
{


    public function index()
    {
        $ledgerGroups = LedgerGroup::query()->latest()->get();
        View::share('title', 'Ledger Groups');
        return view('acc::ledger_groups.index', compact('ledgerGroups'));
    }

    public function createForm()
    {
        // Fetch $BANK_ACCOUNTS from LedgerHelper
        $bankAccounts = LedgerHelper::$BANK_ACCOUNTS;

        // Fetch all LedgerGroups
        $ledgerGroups = LedgerGroup::all();

        // Pass variables to the view
        return view('partials.ajax-ledger-create-form', compact('bankAccounts', 'ledgerGroups'));
    }

    public function trash()
    {
        $ledgerGroups = LedgerGroup::onlyTrashed()->latest()->get();
        View::share('title', 'Trashed Ledger Groups');
        return view('acc::ledger_groups.trash', compact('ledgerGroups'));
    }


    public function create()
    {
        View::share('title', 'Create New Ledger Group');
        $bankAccounts = LedgerHelper::$BANK_ACCOUNTS;
        return view('acc::ledger_groups.create',compact('bankAccounts'));
    }

    public function store(Request $request)
    {


        $data = $this->getData($request);
        LedgerGroup::create($data);

        return redirect()->route('ledger_groups.ledger_group.index')
            ->with('success_message', 'Ledger Group was successfully added.');

    }


    public function show($id)
    {
        View::share('title', 'Ledger Group Details');
        $ledgerGroup = LedgerGroup::findOrFail($id);

        return view('acc::ledger_groups.show', compact('ledgerGroup'));
    }


    public function edit($id)
    {
        View::share('title', 'Edit Ledger Group');
        $ledgerGroup = LedgerGroup::findOrFail($id);

        return view('acc::ledger_groups.edit', compact('ledgerGroup'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $ledgerGroup = LedgerGroup::findOrFail($id);
        $ledgerGroup->update($data);

        return redirect()->route('ledger_groups.ledger_group.index')
            ->with('success_message', 'Ledger Group was successfully updated.');

    }


    public function destroy($id)
    {

        $ledgerGroup = LedgerGroup::findOrFail($id);
        if ($ledgerGroup->is_default) {
            return back()->withInput()
                ->with('unexpected_error', 'Default Ledger group can not be deleted.');
        }
        if (count(Ledger::query()->where('ledger_group_id', $ledgerGroup->id)->get()) > 0) {
            return back()->withInput()
                ->with('unexpected_error', 'Ledger group already in use. Cant be deleted.');
        }
        if (count(LedgerGroup::query()->where('parent', $ledgerGroup->id)->get()) > 0) {
            return back()->withInput()
                ->with('unexpected_error', 'Ledger group has child that needs to be deleted first');
        }

        $ledgerGroup->delete();
        return redirect()->route('ledger_groups.ledger_group.index')
            ->with('success_message', 'Ledger Group was successfully deleted.');

    }

    public function restore($id)
    {
        $ledgerGroup = LedgerGroup::withTrashed()->findOrFail($id);
        $ledgerGroup->restore();

        return redirect()->route('ledger_groups.ledger_group.trash')
            ->with('success_message', 'Ledger Group was successfully restored.');

    }


    public function getData(Request $request, $id = false)
    {

        $rules = [
            'group_name' => 'required',
            'parent' => 'required',
            'nature' => 'nullable',
            'cashflow_type' => 'nullable',
        ];

        $data = $request->validate($rules);
        $isPrimary = $data['parent'] == -1;
        if (!$isPrimary) {
            $data['nature'] = null;
            $data['cashflow_type'] = null;
        }


        return $data;
    }

}
