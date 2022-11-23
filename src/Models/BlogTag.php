<?php

namespace Elfcms\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogTag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tags', 'blog_posts_id', 'blog_tags_id');
    }


    public static function boot() {

        parent::boot();

        static::creating(function($item) {

            //Log::info('Creating event call: '.$item);

        });

        static::created(function($item) {

            //Log::info('Created event call: '.$item);

        });

        static::updating(function($item) {

            //Log::info('Updating event call: '.$item);

        });

        static::updated(function($item) {

            //Log::info('Updated event call: '.$item);

        });

        static::deleted(function($item) {

            //Log::info('Deleted event call: '.$item);

        });
    }

}
