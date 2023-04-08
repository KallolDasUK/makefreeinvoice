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
        $posts = Post::orderBy('date', 'desc')->get();


        return view('master.post.index', compact('posts'));
    }


    public function create()
    {
        $categories = BlogCategory::pluck('category_name', 'id')->all();
        return view('master.post.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $data = $this->getData($request);

//        Post::create($data);
        Post::savePost($request);
        return redirect()->route('post.index')
            ->with('success_message', 'Post was successfully added.');
    }


    public function show( $id)
    {
//        dd('the value of variable jannat is',$jannat);
        $post = Post::find($id);
//        dd($post->updated_at->format('h:i A'));

        return view('master.post.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $categories = BlogCategory::pluck('category_name', 'id')->all();
        return view('master.post.edit', compact('categories', 'post'));
    }


    public function update(Request $request, $post)
    {
        $data = $this->getData($request, $post);

        Post::updatePost($request, $post);

//        $posts->update($data);
        return redirect()->route('post.index')
            ->with('success_message', 'Post was successfully updated.');
    }


    public function destroy($post)
    {
        $post = Post::findOrFail($post);
        $post->delete();
        return redirect()->route('post.index')
            ->with('success_message', 'post was successfully deleted.');
    }

    protected function getData(Request $request, $id = null)
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
        ];

        if ($id == null) {
            $rules['banner'] = 'required';
        } else {
            $rules['banner'] = 'nullable';
        }

        $data = $request->validate($rules);


        return $data;
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
