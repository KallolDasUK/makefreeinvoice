<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'category_id', 'meta_title',
        'meta_description', 'short_summery', 'content', 'author_name',
        'date', 'banner', 'featured_image', 'publish','slug'];
    public static $post;

    public static function savePost( $request)
    {
        $data= $request->except('_token');
//        dd($request->all());


        if($request->hasFile('banner')){
            $imageUrl= $request->banner->store('public');
            $imageUrl= substr($imageUrl, 7);
            $data['banner']= $imageUrl;
        }


        if($request->hasFile('featured_image')){
            $imageUrl= $request->featured_image->store('public');
            $imageUrl= substr($imageUrl, 7);
            $data['featured_image']= $imageUrl;
        }
        Post::create($data);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public static function  updatePost(\Illuminate\Http\Request $request,$post)
    {
        $data= $request->except('_token');

        if($request->hasFile('banner')){
            $imageUrl= $request->banner->store('public');
            $imageUrl= substr($imageUrl, 7);
            $data['banner']= $imageUrl;
        }


        if($request->hasFile('featured_image')){
            $imageUrl= $request->featured_image->store('public');
            $imageUrl= substr($imageUrl, 7);
            $data['featured_image']= $imageUrl;
        }
//        dd($request->all());
        Post::find($post)->update($data);
    }
}
