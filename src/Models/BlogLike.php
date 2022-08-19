<?php

namespace Elfcms\Blog\Models;

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
        return $this->belongsTo(BlogPost::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,);
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
