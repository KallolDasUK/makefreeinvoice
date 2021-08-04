<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class BlogsController extends Controller
{


    public function index()
    {
        $blogs = Blog::query()->paginate(25);
        return view('blogs.index', compact('blogs'));
    }


    public function create()
    {

        return view('blogs.create');
    }


    public function store(Request $request)
    {


        $data = $this->getData($request);

        Blog::create($data);

        return redirect()->route('blogs.blog.index')->with('success_message', 'Blog was successfully added.');

    }


    public function show($slug)
    {
        $blog = Blog::query()->firstWhere('slug', $slug);

        return view('blogs.show', compact('blog'));
    }


    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        return view('blogs.edit', compact('blog'));
    }

    public function update($id, Request $request)
    {


        $data = $this->getData($request);

        $blog = Blog::findOrFail($id);
        $blog->update($data);

        return redirect()->route('blogs.blog.index')
            ->with('success_message', 'Blog was successfully updated.');

    }


    public function destroy($id)
    {

        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('blogs.blog.index')
            ->with('success_message', 'Blog was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
            'title' => 'required',
            'body' => 'required'
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
