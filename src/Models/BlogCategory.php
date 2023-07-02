<?php

namespace Elfcms\Blog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'blog_id',
        'name',
        'slug',
        'parent_id',
        'image',
        'preview',
        'description',
        'active',
        'public_time',
        'end_time',
        'meta_keywords',
        'meta_description'
    ];

    public static function tree($parent = null)
    {
        if ($parent !== null) {
            $parent = intval($parent);
            if ($parent == 0) {
                $parent = null;
            }
        }
        $result = [];
        $result = self::where('parent_id',$parent)->get();
        if (!empty($result)) {
            foreach ($result as $i => $item) {
                $sublevelData = self::tree($item->id);
                if (!empty($sublevelData)) {
                    $result[$i]['children'] = $sublevelData;
                }
            }
        }

        return $result;
    }

    public static function flat($parent = null, $level = 0, $trend = 'asc', $order = 'id', $count = 100, $search = '')
    {
        /* $trend = 'asc';
        $order = 'id'; */
        if (!empty($trend) && $trend == 'desc') {
            $trend = 'desc';
        }
        if (!empty($order)) {
            $order = $order;
        }
        if (!empty($count)) {
            $count = intval($count);
        }
        if (empty($count)) {
            $count = 100;
        }
        if ($parent !== null) {
            $parent = intval($parent);
            if ($parent == 0) {
                $parent = null;
            }
        }
        $result = [];
        //$data = self::where('parent_id',$parent)->get();
        if (!empty($search)) { //only for 0 level
            $data = self::where('parent_id',$parent)->where('name','like',"%{$search}%")->orderBy($order, $trend)->paginate($count);
        }
        else {
            $data = self::where('parent_id',$parent)->orderBy($order, $trend)->paginate($count);
        }

        if (!empty($data)) {
            foreach ($data as $item) {
                $item['level'] = $level;
                $result[] = $item;
                $sublevelData = self::flat(parent: $item->id, level: $level+1);
                if (!empty($sublevelData)) {
                    $result = array_merge($result, $sublevelData);
                }
            }
        }

        return $result;
    }

    public static function children($id, $subchild=false)
    {
        $result = [];
        $data = self::where('parent_id',$id)->get();

        foreach ($data as $item) {
            $result[] = $item;
            if ($subchild) {
                $subresult = self::children($item->id,$subchild);
                if (!empty($subresult)) {
                    $result = array_merge($result, $subresult);
                }
            }

        }

        return $result;
    }

    public static function childrenid($id, $subchild=false)
    {
        $result = [];
        $data = self::where('parent_id',$id)->get('id');

        foreach ($data as $item) {
            $result[] = $item->id;
            if ($subchild) {
                $subresult = self::childrenid($item->id,$subchild);
                if (!empty($subresult)) {
                    $result = array_merge($result, $subresult);
                }
            }

        }

        return $result;
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    /* public function posts ()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    } */

    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_categories', 'blog_posts_id', 'blog_categories_id');
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
