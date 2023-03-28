<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Post;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function article_page()
    {
        return view('landing.article',[
            'posts' => Post::where('publish', 1)->get(),
        ]);
    }
    public function  article_details($slug)
    {
        return view('landing.article_details',[
            'post' => Post::where('slug',$slug)->first()
        ]);
    }
}
