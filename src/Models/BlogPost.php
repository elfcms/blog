<?php

namespace Elfcms\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'image',
        'preview',
        'description',
        'text',
        'active',
        'public_time',
        'end_time'
    ];

    public $vote, $userVote = 0, $like, $userLike = 0;

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
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
        $this->likeResult = $this->likes()->where('value','>','0')->count();
        $this->dislikeResult = $this->likes()->where('value','<','0')->count();

        if (Auth::check()) {
            $user = Auth::user();
            $userLike =$this->likes()->where('user_id',$user->id)->first();
            if (!empty($userLike)) {
                $this->userLike = $userLike->value;
            }
        }

        return $this->like = ['likes' => $this->likeResult, 'dislikes' => $this->dislikeResult, 'user_value'=> $this->userLike];
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
            $vote = $this->votes()->where('user_id',$user->id)->first();
            if (!empty($vote)) {
                $this->userVote = $vote->value;
            }
        }

        return $this->vote = ['value'=>$result,'count'=>$count,'text'=>number_format($result,1,','),'user_value'=>$this->userVote];
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


    public static function boot() {

        parent::boot();

        static::retrieved(function($item) {

            Log::info('retrieved event call: '.$item->category);

        });

        static::creating(function($item) {

            //Log::info('Creating event call: '.$item);

        });

        static::created(function($item) {

            //Log::info('Created event call: '.$item);

        });

        static::updating(function($item) {

            Log::info('Updating event call: '.$item);

        });

        static::updated(function($item) {

            Log::info('Updated event call: '.$item);

        });

        static::saving(function($item) {

            Log::info('saving event call: '.$item);

        });

        static::saved(function($item) {

            Log::info('saved event call: '.$item);

        });

        static::deleting(function($item) {

            Log::info('deleting event call: '.$item);

        });

        static::deleted(function($item) {

            Log::info('Deleted event call: '.$item);

        });

        static::restoring(function($item) {

            Log::info('restoring event call: '.$item);

        });

        static::restored(function($item) {

            Log::info('restored event call: '.$item);

        });

        static::replicating(function($item) {

            //Log::info('replicating event call: '.$item);

        });

    }

}
