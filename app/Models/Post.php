<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'category_id', 'meta_title',
        'meta_description', 'short_summery', 'content', 'author_name',
        'date', 'banner', 'featured_image', 'published'];
    public static $post;

    public static function savePost($request)
    {
        Post::create($request->except('_token'));


    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public static function  updatePost($request,$post)
    {
        Post::find($post)->update($request->except('_token'));
    }
}
