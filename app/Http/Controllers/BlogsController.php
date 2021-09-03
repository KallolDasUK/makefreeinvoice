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
        $description = strip_tags(preg_replace('<!--*-->', '', $blog->body));

        SEOMeta::setTitle($blog->title);
        SEOMeta::setDescription($description);
        SEOMeta::addMeta('article:published_time', $blog->created_at->toW3CString(), 'property');

        SEOMeta::addMeta('article:section', $blog->title . ' ' . implode(',', $blog->blog_tag_names), 'property');
        SEOMeta::addKeyword($blog->blog_tag_names);
//        dd($description);
        OpenGraph::setDescription($description);
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
        JsonLd::setDescription($description);
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
        OpenGraph::setTitle($blog->title)
            ->setDescription($description)
            ->setType('article')
            ->setArticle([
                'published_time' => $blog->created_at,
                'modified_time' => $blog->updated_at,
                'author' => 'Invoice/Online Billing',
                'section' => 'Invoice/Online Billing',
                'tag' => $blog->blog_tag_names,
            ]);

        // Namespace URI: http://ogp.me/ns/book#
        // book
        OpenGraph::setTitle('Book')
            ->setDescription('Some Book')
            ->setType('book')
            ->setBook([
                'author' => 'profile / array',
                'isbn' => 'string',
                'release_date' => 'datetime',
                'tag' => 'string / array'
            ]);

        // Namespace URI: http://ogp.me/ns/profile#
        // profile
        OpenGraph::setTitle('Profile')
            ->setDescription('Some Person')
            ->setType('profile')
            ->setProfile([
                'first_name' => 'string',
                'last_name' => 'string',
                'username' => 'string',
                'gender' => 'enum(male, female)'
            ]);

        // Namespace URI: http://ogp.me/ns/music#
        // music.song
        OpenGraph::setType('music.song')
            ->setMusicSong([
                'duration' => 'integer',
                'album' => 'array',
                'album:disc' => 'integer',
                'album:track' => 'integer',
                'musician' => 'array'
            ]);

        // music.album
        OpenGraph::setType('music.album')
            ->setMusicAlbum([
                'song' => 'music.song',
                'song:disc' => 'integer',
                'song:track' => 'integer',
                'musician' => 'profile',
                'release_date' => 'datetime'
            ]);

        //music.playlist
        OpenGraph::setType('music.playlist')
            ->setMusicPlaylist([
                'song' => 'music.song',
                'song:disc' => 'integer',
                'song:track' => 'integer',
                'creator' => 'profile'
            ]);

        // music.radio_station
        OpenGraph::setType('music.radio_station')
            ->setMusicRadioStation([
                'creator' => 'profile'
            ]);

        // Namespace URI: http://ogp.me/ns/video#
        // video.movie
        OpenGraph::setType('video.movie')
            ->setVideoMovie([
                'actor' => 'profile / array',
                'actor:role' => 'string',
                'director' => 'profile /array',
                'writer' => 'profile / array',
                'duration' => 'integer',
                'release_date' => 'datetime',
                'tag' => 'string / array'
            ]);

        // video.episode
        OpenGraph::setType('video.episode')
            ->setVideoEpisode([
                'actor' => 'profile / array',
                'actor:role' => 'string',
                'director' => 'profile /array',
                'writer' => 'profile / array',
                'duration' => 'integer',
                'release_date' => 'datetime',
                'tag' => 'string / array',
                'series' => 'video.tv_show'
            ]);

        // video.tv_show
        OpenGraph::setType('video.tv_show')
            ->setVideoTVShow([
                'actor' => 'profile / array',
                'actor:role' => 'string',
                'director' => 'profile /array',
                'writer' => 'profile / array',
                'duration' => 'integer',
                'release_date' => 'datetime',
                'tag' => 'string / array'
            ]);

        // video.other
        OpenGraph::setType('video.other')
            ->setVideoOther([
                'actor' => 'profile / array',
                'actor:role' => 'string',
                'director' => 'profile /array',
                'writer' => 'profile / array',
                'duration' => 'integer',
                'release_date' => 'datetime',
                'tag' => 'string / array'
            ]);

        // og:video
        OpenGraph::addVideo('http://example.com/movie.swf', [
            'secure_url' => 'https://example.com/movie.swf',
            'type' => 'application/x-shockwave-flash',
            'width' => 400,
            'height' => 300
        ]);

        // og:audio
        OpenGraph::addAudio('http://example.com/sound.mp3', [
            'secure_url' => 'https://secure.example.com/sound.mp3',
            'type' => 'audio/mpeg'
        ]);

        // og:place
        OpenGraph::setTitle('Place')
            ->setDescription('Some Place')
            ->setType('place')
            ->setPlace([
                'location:latitude' => 'float',
                'location:longitude' => 'float',
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
        ];
        if ($blog) {
            $rules = [
                'title' => 'required',
                'slug' => 'required|unique:blogs,slug,' . $blog->id,
                'body' => 'required',
                'tags' => 'nullable',
            ];
        }
//        dd($rules);


        $data = $request->validate($rules);
        $data['tags'] = json_encode($data['tags'] ?? []);
//        dd($data);

        return $data;
    }

}
