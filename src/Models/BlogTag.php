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


    public static function boot()
    {

        parent::boot();

        static::creating(function ($post) {

            //Log::info('Creating event call: '.$post);

        });

        static::created(function ($post) {

            //Log::info('Created event call: '.$post);

        });

        static::updating(function ($post) {

            //Log::info('Updating event call: '.$post);

        });

        static::updated(function ($post) {

            //Log::info('Updated event call: '.$post);

        });

        static::deleted(function ($post) {

            //Log::info('Deleted event call: '.$post);

        });
    }
}
