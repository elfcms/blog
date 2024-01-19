<?php

namespace Elfcms\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'blog_id',
        'name',
        'slug',
        'category_id',
        'image',
        'preview',
        'description',
        'text',
        'active',
        'public_time',
        'end_time',
        'meta_keywords',
        'meta_description'
    ];

    public $vote, $userVote = 0, $like, $userLike = 0;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopePosition($query)
    {
        return $query->orderBy('position');
    }

    public function getPostDateAttribute()
    {
        $value = $this->public_time ?? $this->created_at;
        return Carbon::parse($value)->format('d.m.Y');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_post_categories', 'blog_posts_id', 'blog_categories_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tags', 'blog_posts_id', 'blog_tags_id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'post_id');
    }

    public function votes()
    {
        return $this->hasMany(BlogVote::class, 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(BlogLike::class, 'post_id');
    }

    public function getLike()
    {
        $this->likeResult = $this->likes()->where('value', '>', '0')->count();
        $this->dislikeResult = $this->likes()->where('value', '<', '0')->count();

        if (Auth::check()) {
            $user = Auth::user();
            $userLike = $this->likes()->where('user_id', $user->id)->first();
            if (!empty($userLike)) {
                $this->userLike = $userLike->value;
            }
        }

        return $this->like = ['likes' => $this->likeResult, 'dislikes' => $this->dislikeResult, 'user_value' => $this->userLike];
    }

    public function getVote()
    {
        //dd(count($this->votes));
        $result = 0;
        $sum = 0;
        $count = count($this->votes);
        if ($count > 0) {
            foreach ($this->votes as $vote) {
                $sum += intval($vote->value);
            }
            $result = round($sum / $count, 1);
        }
        if (Auth::check()) {
            $user = Auth::user();
            $vote = $this->votes()->where('user_id', $user->id)->first();
            if (!empty($vote)) {
                $this->userVote = $vote->value;
            }
        }

        return $this->vote = ['value' => $result, 'count' => $count, 'text' => number_format($result, 1, ','), 'user_value' => $this->userVote];
    }

    /* public function getUserVote()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $vote = $this->votes()->where('user_id',$user->id)->first();
            if (!empty($vote)) {
                $this->userVote = $vote;
            }
        }

        return $this->userVote;
    } */


    public static function boot()
    {

        parent::boot();

        static::retrieved(function ($post) {

            Log::info('retrieved event call: ' . $post->category);
        });

        static::creating(function ($post) {

            //Log::info('Creating event call: '.$post);

        });

        static::created(function ($post) {

            //Log::info('Created event call: '.$post);

        });

        static::updating(function ($post) {

            Log::info('Updating event call: ' . $post);
        });

        static::updated(function ($post) {

            Log::info('Updated event call: ' . $post);
        });

        static::saving(function ($post) {

            Log::info('saving event call: ' . $post);
        });

        static::saved(function ($post) {

            Log::info('saved event call: ' . $post);
        });

        static::deleting(function ($post) {

            Log::info('deleting event call: ' . $post);
        });

        static::deleted(function ($post) {

            Log::info('Deleted event call: ' . $post);
        });

        static::restoring(function ($post) {

            Log::info('restoring event call: ' . $post);
        });

        static::restored(function ($post) {

            Log::info('restored event call: ' . $post);
        });

        static::replicating(function ($post) {

            //Log::info('replicating event call: '.$post);

        });
    }
}
