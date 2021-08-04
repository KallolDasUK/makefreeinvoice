<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
                  'user_id',
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
    static::creating(function($activity) {

        // produce a slug based on the activity title
        $slug = \Str::slug($activity->title);

        // check to see if any other slugs exist that are the same & count them
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        // if other slugs exist that are the same, append the count to the slug
        $activity->slug = $count ? "{$slug}-{$count}" : $slug;

    });
}


}
