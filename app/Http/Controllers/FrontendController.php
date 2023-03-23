<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function article_page()
    {
        return view('landing.article');
    }
}
