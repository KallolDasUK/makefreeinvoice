<?php

namespace App\Models;

use FontLib\Table\Type\name;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Blog
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $body
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string $tags
 * @property string|null $meta
 * @property-read mixed $blog_tag_names
 * @property-read mixed $blog_tags
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUserId($value)
 * @mixin \Eloquent
 */
class Blog extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blogs';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
        'tags',
        'user_id',
        'meta',
        'client_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected static function boot()
    {
        parent::boot();
        // registering a callback to be executed upon the creation of an activity AR
        static::creating(function ($activity) {

            // produce a slug based on the activity title
            $slug = \Str::slug($activity->title);

            // check to see if any other slugs exist that are the same & count them
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            // if other slugs exist that are the same, append the count to the slug
            $activity->slug = $count ? "{$slug}-{$count}" : $slug;

        });
    }

    public function getBlogTagsAttribute()
    {
        $ids = json_decode($this->tags ?? '[]') ?? [];
        $blogTags = BlogTag::find($ids);
        return $blogTags;
    }

    public function getBlogTagNamesAttribute()
    {
        $ids = json_decode($this->tags ?? '[]') ?? [];
        $names = [];
        $blogTags = BlogTag::find($ids);
        if ($blogTags) {
            $names = $blogTags->pluck('name')->toArray();
        }
        return $names;
    }


}
