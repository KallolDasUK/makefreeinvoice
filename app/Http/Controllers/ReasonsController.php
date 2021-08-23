<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use Illuminate\Http\Request;
use Exception;

class ReasonsController extends Controller
{


    public function index()
    {
        $reasons = Reason::paginate(25);

        return view('reasons.index', compact('reasons'));
    }


    public function create()
    {


        return view('reasons.create');
    }


    public function store(Request $request)
    {

        $data = $this->getData($request);

        $reason = Reason::create($data);
        if ($request->ajax()) {
            return $reason;
        }

        return redirect()->route('reasons.reason.index')
            ->with('success_message', 'Reason was successfully added.');

    }


    public function show($id)
    {
        $reason = Reason::findOrFail($id);

        return view('reasons.show', compact('reason'));
    }


    public function edit($id)
    {
        $reason = Reason::findOrFail($id);


        return view('reasons.edit', compact('reason'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $reason = Reason::findOrFail($id);
        $reason->update($data);

        return redirect()->route('reasons.reason.index')
            ->with('success_message', 'Reason was successfully updated.');

    }


    public function destroy($id)
    {

        $reason = Reason::findOrFail($id);
        $reason->delete();

        return redirect()->route('reasons.reason.index')
            ->with('success_message', 'Reason was successfully deleted.');

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
            'name' => 'required|nullable|string|min:1|max:255',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
