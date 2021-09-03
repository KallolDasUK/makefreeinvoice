<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Exception;

class BlogTagsController extends Controller
{

    /**
     * Display a listing of the blog tags.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $blogTags = BlogTag::paginate(25);

        return view('blog_tags.index', compact('blogTags'));
    }

    /**
     * Show the form for creating a new blog tag.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        

        return view('blog_tags.create');
    }

    /**
     * Store a new blog tag in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

            
            $data = $this->getData($request);
            
            BlogTag::create($data);

            return redirect()->route('blog_tags.blog_tag.index')
                ->with('success_message', 'Blog Tag was successfully added.');

    }

    /**
     * Display the specified blog tag.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $blogTag = BlogTag::findOrFail($id);

        return view('blog_tags.show', compact('blogTag'));
    }

    /**
     * Show the form for editing the specified blog tag.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $blogTag = BlogTag::findOrFail($id);
        

        return view('blog_tags.edit', compact('blogTag'));
    }

    /**
     * Update the specified blog tag in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

            
            $data = $this->getData($request);
            
            $blogTag = BlogTag::findOrFail($id);
            $blogTag->update($data);

            return redirect()->route('blog_tags.blog_tag.index')
                ->with('success_message', 'Blog Tag was successfully updated.');

    }

    /**
     * Remove the specified blog tag from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $blogTag = BlogTag::findOrFail($id);
            $blogTag->delete();

            return redirect()->route('blog_tags.blog_tag.index')
                ->with('success_message', 'Blog Tag was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'name' => 'nullable', 
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
