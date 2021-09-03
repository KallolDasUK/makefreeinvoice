<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogTag;
use App\Models\User;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
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
        $blogTags = BlogTag::all();
        $tags = [];
        return view('blogs.create', compact('blogTags', 'tags'));
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
        view()->share('title', $blog->title);

        SEOMeta::setTitle($blog->title);
        SEOMeta::setDescription($blog->meta);
        SEOMeta::addMeta('article:published_time', $blog->created_at->toW3CString(), 'property');

        SEOMeta::addMeta('article:section', $blog->title . ' ' . implode(',', $blog->blog_tag_names), 'property');
        SEOMeta::addKeyword($blog->blog_tag_names);
//        dd($description);
        OpenGraph::setDescription($blog->meta);
        OpenGraph::setTitle($blog->title);
        OpenGraph::setUrl(route('blogs.blog.show', $blog->slug));
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'pt-br');
        OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);


        $content = $blog->body;
        preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $content, $urls);

        foreach ($urls as $url) {
            OpenGraph::addImage(['url' => $url, 'size' => 300]);

        }


        JsonLd::setTitle($blog->title);
        JsonLd::setDescription($blog->meta);
        JsonLd::setType('Article');
//        JsonLd::addImage($blog->images->list('url'));

        // OR with multi

        JsonLdMulti::setTitle($blog->title);
        JsonLdMulti::setDescription($blog->body);
        JsonLdMulti::setType('Article');
//        JsonLdMulti::addImage($blog->images->list('url'));
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle('Page Article - ' . $blog->title);
        }

        // Namespace URI: http://ogp.me/ns/article#
        // article
        OpenGraph::setTitle('Article')
            ->setDescription($blog->meta)
            ->setType('article')
            ->setArticle([
                'published_time' => $blog->created_at,
                'modified_time' => $blog->updated_at,
                'author' => 'Invoice/Online Billing',
                'section' => 'Invoice/Online Billing',
                'tag' => $blog->blog_tag_names,
            ]);


        return view('blogs.show', compact('blog'));
    }


    public function edit($id)
    {
        $blogTags = BlogTag::all();
        $blog = Blog::findOrFail($id);
        $tags = json_decode($blog->tags ?? '[]') ?? [];
//        dd($tags);

        return view('blogs.edit', compact('blog', 'blogTags', 'tags'));
    }

    public function update($id, Request $request)
    {


        $blog = Blog::findOrFail($id);
        $data = $this->getData($request, $blog);

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


    protected function getData(Request $request, Blog $blog = null)
    {


        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:blogs,slug',
            'body' => 'required',
            'tags' => 'nullable',
            'meta' => 'nullable',
        ];
        if ($blog) {
            $rules = [
                'title' => 'required',
                'slug' => 'required|unique:blogs,slug,' . $blog->id,
                'body' => 'required',
                'tags' => 'nullable',
                'meta' => 'nullable',

            ];
        }
//        dd($rules);


        $data = $request->validate($rules);
        $data['tags'] = json_encode($data['tags'] ?? []);
//        dd($data);

        return $data;
    }

}
