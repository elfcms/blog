<?php

namespace Elfcms\Blog\Models;

use DateTimeInterface;
use Elfcms\Elfcms\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'blog_id',
        'post_id',
        'parent_id',
        'user_id',
        'text'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public static function tree($parent = null)
    {
        if ($parent !== null) {
            $parent = intval($parent);
            if ($parent == 0) {
                $parent = null;
            }
        }
        $result = [];
        $result = self::where('parent_id', $parent)->get();
        if (!empty($result)) {
            foreach ($result as $i => $post) {
                $sublevelData = self::tree($post->id);
                if (!empty($sublevelData)) {
                    $result[$i]['children'] = $sublevelData;
                }
            }
        }

        return $result;
    }

    public static function simpleTree($firstNew = false)
    {
        $order = 'asc';
        if ($firstNew) {
            $order = 'desc';
        }
        $result = self::where('parent_id', null)->orderBy('created_at', $order)->get();

        if (!empty($result)) {
            foreach ($result as $i => $post) {
                $sublevelData = self::children($post->id, true, false);
                if (!empty($sublevelData)) {
                    $result[$i]['answers'] = $sublevelData;
                }
            }
        }

        return $result;
    }

    public static function flat($parent = null, $level = 0)
    {
        if ($parent !== null) {
            $parent = intval($parent);
            if ($parent == 0) {
                $parent = null;
            }
        }
        $result = [];
        $data = self::where('parent_id', $parent)->get();
        if (!empty($data)) {
            foreach ($data as $post) {
                $post['level'] = $level;
                $result[] = $post;
                $sublevelData = self::flat($post->id, $level + 1);
                if (!empty($sublevelData)) {
                    $result = array_merge($result, $sublevelData);
                }
            }
        }

        return $result;
    }

    public static function children($id, $subchild = false, $firstNew = false)
    {
        $order = 'asc';
        if ($firstNew) {
            $order = 'desc';
        }

        $result = [];
        $data = self::where('parent_id', $id)->orderBy('created_at', $order)->get();

        foreach ($data as $post) {
            $result[] = $post;
            if ($subchild) {
                $subresult = self::children($post->id, $subchild);
                if (!empty($subresult)) {
                    $result = array_merge($result, $subresult);
                }
            }
        }

        return $result;
    }

    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(BlogComment::class);
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
