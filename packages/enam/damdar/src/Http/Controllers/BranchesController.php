<?php

namespace Enam\Acc\Http\Controllers;

use Enam\Acc\Http\Controllers\Controller;
use Enam\Acc\Models\Branch;
use Enam\Acc\Models\Transaction;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\View;


class BranchesController extends Controller
{

    /**
     * Display a listing of the branches.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        View::share('title', 'Branches');
        $branches = Branch::query()->latest()->get();

        return view('acc::branches.index', compact('branches'));
    }

    public function trash()
    {
        View::share('title', 'Trashed Branches');
        $branches = Branch::onlyTrashed()->get();

        return view('acc::branches.trash', compact('branches'));
    }

    /**
     * Show the form for creating a new branch.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {

        View::share('title', 'Create New Branch');

        return view('acc::branches.create');
    }

    /**
     * Store a new branch in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);

            Branch::create($data);

            return redirect()->route('branches.branch.index')
                ->with('success_message', 'Branch was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified branch.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        View::share('title', 'Show Branch');
        $branch = Branch::findOrFail($id);

        return view('acc::branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        View::share('title', 'Edit Branch');
        $branch = Branch::findOrFail($id);


        return view('acc::branches.edit', compact('branch'));
    }

    /**
     * Update the specified branch in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {

            $data = $this->getData($request);

            $branch = Branch::findOrFail($id);
            $branch->update($data);

            return redirect()->route('branches.branch.index')
                ->with('success_message', 'Branch was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Remove the specified branch from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id)
    {
        $hard = $request->hard ?? false;
//        dd($request->all(),$hard);
        $branch = Branch::withTrashed()->findOrFail($id);

        if ($hard) $branch->forceDelete();
        else {
            if (Transaction::query()->where('branch_id', $id)->count()) {
                return redirect()->route('branches.branch.index')
                    ->with('unexpected_error', 'Branch already in use.');
            } else {
                $branch->delete();

            }
        }

        return redirect()->route('branches.branch.index')
            ->with('success_message', 'Branch was successfully deleted.');

    }

    public function restore($id)
    {

        $branch = Branch::withTrashed()->findOrFail($id);
        $branch->restore();

        return redirect()->route('branches.branch.trash')
            ->with('success_message', 'Branch was successfully restored.');

    }


    protected function getData(Request $request, $id = null)
    {
        $rules = [
            'name' => 'string|min:1|max:255|nullable',
            'location' => 'nullable|string|min:0',
            'description' => 'nullable|string|min:0|max:1000',
        ];


        $data = $request->validate($rules);

        return $data;
    }

}
