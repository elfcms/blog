<?php

namespace Elfcms\Blog\Models;

use Elfcms\Elfcms\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'value'
    ];

    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'blog_posts_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
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
