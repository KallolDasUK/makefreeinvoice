<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Exception;

class VendorsController extends Controller
{


    public function index()
    {
        $vendors = Vendor::paginate(25);

        return view('vendors.index', compact('vendors'));
    }


    public function create()
    {


        return view('vendors.create');
    }

    public function store(Request $request)
    {


        $data = $this->getData($request);

        Vendor::create($data);

        return redirect()->route('vendors.vendor.index')
            ->with('success_message', 'Vendor was successfully added.');

    }


    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);

        return view('vendors.show', compact('vendor'));
    }


    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);


        return view('vendors.edit', compact('vendor'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $vendor = Vendor::findOrFail($id);
        $vendor->update($data);

        return redirect()->route('vendors.vendor.index')
            ->with('success_message', 'Vendor was successfully updated.');

    }


    public function destroy($id)
    {

        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('vendors.vendor.index')
            ->with('success_message', 'Vendor was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'required|nullable|string|min:1|max:255',
            'photo' => ['file', 'nullable'],
            'company_name' => 'string|min:1|nullable',
            'phone' => 'string|min:1|nullable',
            'email' => 'nullable',
            'country' => 'nullable',
            'street_1' => 'string|min:1|nullable',
            'street_2' => 'string|min:1|nullable',
            'city' => 'string|min:1|nullable',
            'state' => 'string|min:1|nullable',
            'zip_post' => 'string|min:1|nullable',
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