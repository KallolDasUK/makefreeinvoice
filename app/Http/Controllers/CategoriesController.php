<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{


    public function index()
    {
        $categories = Category::with('category')->latest()->get();

        return view('categories.index', compact('categories'));
    }


    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();

        return view('categories.create', compact('categories'));
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        $category = Category::create($data);
        if ($request->ajax()) {
            return $category;
        }

        return redirect()->route('categories.category.index')
            ->with('success_message', 'Category was successfully added.');

    }


    public function show($id)
    {
        $category = Category::with('category')->findOrFail($id);

        return view('categories.show', compact('category'));
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::pluck('name', 'id')->all();

        return view('categories.edit', compact('category', 'categories'));
    }


    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $category = Category::findOrFail($id);
        $category->update($data);

        return redirect()->route('categories.category.index')
            ->with('success_message', 'Category was successfully updated.');

    }


    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect()->route('categories.category.index')
                ->with('success_message', 'Category was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }


    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'required|nullable|string|min:1|max:255',
            'category_id' => 'nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
