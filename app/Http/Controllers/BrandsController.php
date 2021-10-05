<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Exception;

class BrandsController extends Controller
{

    /**
     * Display a listing of the brands.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $brands = Brand::paginate(25);

        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new brand.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        

        return view('brands.create');
    }

    /**
     * Store a new brand in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

            
            $data = $this->getData($request);
            
            Brand::create($data);

            return redirect()->route('brands.brand.index')
                ->with('success_message', 'Brand was successfully added.');

    }

    /**
     * Display the specified brand.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $brand = Brand::findOrFail($id);

        return view('brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified brand.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        

        return view('brands.edit', compact('brand'));
    }

    /**
     * Update the specified brand in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

            
            $data = $this->getData($request);
            
            $brand = Brand::findOrFail($id);
            $brand->update($data);

            return redirect()->route('brands.brand.index')
                ->with('success_message', 'Brand was successfully updated.');

    }

    /**
     * Remove the specified brand from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();

            return redirect()->route('brands.brand.index')
                ->with('success_message', 'Brand was successfully deleted.');
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
                'name' => 'nullable|string|min:0|max:255', 
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
