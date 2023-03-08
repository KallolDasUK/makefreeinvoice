<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoriesController extends Controller
{


    public function index()
    {
        $blogCategories = BlogCategory::latest()->get();


        return view('master.blog-category.index', compact('blogCategories'));
    }


    public function create()
    {
        return view('master.blog-category.create');
    }


    public function store(Request $request)
    {
        BlogCategory::saveBlogCategory($request);
        return redirect()->back()->with('success', 'Blog category created successfully');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        return view('master.blog-category.edit', [
            'blogCategory' => BlogCategory::find($id),
        ]);
    }


    public function update(Request $request, $id)
    {
        BlogCategory::updateCategory($request, $id);
        return redirect(route('blog.category.index'))->with('success', 'Blog category updated successfully');
    }


    public function destroy($id)
    {
        BlogCategory::find($id)->delete();
        return redirect()->back()->with('success', 'Blog category deleted successfully');
    }

}

