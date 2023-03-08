<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $blogCategories;
    public function index()
    {
        $this->blogCategories = BlogCategory:: latest()->get();
        return view('master.blog-category.manage',[
            'blogCategories'  =>$this->blogCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        BlogCategory::saveBlogCategory($request);
        return redirect()->back()->with('success','Blog category created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('master.blog-category.edit',[
            'blogCategory' => BlogCategory::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        BlogCategory::updateCategory($request,$id);
        return redirect('/manage-blog-category')->with('success','Blog category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BlogCategory::find($id)->delete();
        return redirect()->back()->with('success','Blog category deleted successfully');
    }

}


//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//use App\Models\Category;
//
//class CategoryController extends Controller
//{
//    public function index()
//    {
//        $categories = Category::all();
//        return view('categories.index', compact('categories'));
//    }
//
//    public function create()
//    {
//        return view('categories.create');
//    }
//
//    public function store(Request $request)
//    {
//        $validatedData = $request->validate([
//            'name' => 'required|max:255',
//            'published' => 'required|boolean',
//        ]);
//
//        $category = new Category;
//        $category->name = $validatedData['name'];
//        $category->published = $validatedData['published'];
//        $category->save();
//
//        return redirect()->route('categories.index')
//            ->with('success', 'Category created successfully.');
//    }
//
//    public function edit(Category $category)
//    {
//        return view('categories.edit', compact('category'));
//    }
//
//    public function update(Request $request, Category $category)
//    {
//        $validatedData = $request->validate([
//            'name' => 'required|max:255',
//            'published' => 'required|boolean',
//        ]);
//
//        $category->name = $validatedData['name'];
//        $category->published = $validatedData['published'];
//        $category->save();
//
//        return redirect()->route('categories.index')
//            ->with('success', 'Category updated successfully.');
//    }
//
//    public function destroy(Category $category)
//    {
//        $category->delete();
//
//        return redirect()->route('categories.index')
//            ->with('success', 'Category deleted successfully.');
//    }
//}
//
//Write to Enam Babu
//
