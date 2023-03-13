<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();

        return view('master.post.index', compact('posts'));
    }


    public function create()
    {
        $categories = BlogCategory::pluck('category_name', 'id')->all();
        return view('master.post.create', compact('categories'));
    }


    public function store(Request $request)
    {
        Post::savePost($request);
        return redirect()->route('post.index')
            ->with('success_message', 'Post was successfully added.');
    }


    public function show(Post $post)
    {

    }

    public function edit($id)
    {
        $post=Post::find($id);
        $categories = BlogCategory::pluck('category_name', 'id')->all();
        return view('master.post.edit', compact('categories', 'post'));
    }


    public function update(Request $request, Post $post)
    {
        Post::updatePost($request, $post);
        return redirect()->route('post.index')
            ->with('success_message', 'Post was successfully updated.');
    }


    public function destroy(Post $post)
    {
        $post = Post::findOrFail($post);
        AffiliatePayable::query()->where('type', get_class($post))->where('type_id', $post->id)->delete();
        $post->delete();
        return redirect()->route('post.index')
            ->with('success_message', 'post was successfully deleted.');
    }
}
