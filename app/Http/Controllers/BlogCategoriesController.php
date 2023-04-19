<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\AffiliatePayable;
use Illuminate\Http\Request;

class BlogCategoriesController extends Controller
{


    public function index()
    {
        $blogCategories = BlogCategory::query()->orderBy('category_name')->get();


        return view('master.blog-category.index', compact('blogCategories'));

    }


    public function create()
    {
        return view('master.blog-category.create');
    }


    public function store(Request $request)
    {

        BlogCategory::saveBlogCategory($request);
        return redirect()->route('blog.category.index')
            ->with('success_message', 'Blog Category was successfully added.');



    }


    public function show($id)
    {
        $blogCategory = BlogCategory::with('user')->findOrFail($id);

        return view('master.blog-category.show', compact('blogCategory'));
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
        return redirect()->route('blog.category.index')
            ->with('success_message', 'Blog Category was successfully updated.');
    }


    public function destroy($id)
    {
        $blogCategory = BlogCategory::findOrFail($id);
        AffiliatePayable::query()->where('type', get_class($blogCategory))->where('type_id', $blogCategory->id)->delete();
        $blogCategory->delete();
        return redirect()->route('blog.category.index')
            ->with('success_message', 'Blog Category was successfully deleted.');
//        BlogCategory::find($id)->delete();
//        return redirect()->back()->with('success', 'Blog category deleted successfully');
    }

}

