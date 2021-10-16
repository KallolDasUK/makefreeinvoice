<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SR;
use Illuminate\Http\Request;
use Exception;

class SRsController extends Controller
{


    public function index()
    {
        $sRs = SR::paginate(25);
        $title = "Sales Representative";
        return view('s_rs.index', compact('sRs', 'title'));
    }


    public function create()
    {

        $title = "Create Sales Representative";

        return view('s_rs.create', compact('title'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        SR::create($data);

        return redirect()->route('s_rs.s_r.index')
            ->with('success_message', 'S R was successfully added.');

    }


    public function show($id)
    {
        $sR = SR::findOrFail($id);

        return view('s_rs.show', compact('sR'));
    }

    public function edit($id)
    {
        $sR = SR::findOrFail($id);
        $title = "Edit Sales Representative";

        return view('s_rs.edit', compact('sR', 'title'));
    }

    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $sR = SR::findOrFail($id);
        $sR->update($data);

        return redirect()->route('s_rs.s_r.index')
            ->with('success_message', 'S R was successfully updated.');

    }

    public function destroy($id)
    {

        $sR = SR::findOrFail($id);
        $sR->delete();

        return redirect()->route('s_rs.s_r.index')
            ->with('success_message', 'S R was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'required',
            'photo' => ['file', 'nullable'],
            'phone' => 'string|min:1|nullable',
            'email' => 'nullable',
            'address' => 'string|min:1|nullable',
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
