<?php

namespace Elfcms\Blog\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'parent_id',
        'user_id',
        'text'
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

    public static function simpleTree($firstNew = false)
    {
        $order = 'asc';
        if ($firstNew) {
            $order = 'desc';
        }
        $result = self::where('parent_id', null)->orderBy('created_at',$order)->get();

        if (!empty($result)) {
            foreach ($result as $i => $item) {
                $sublevelData = self::children($item->id,true,false);
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
        $data = self::where('parent_id',$parent)->get();
        if (!empty($data)) {
            foreach ($data as $item) {
                $item['level'] = $level;
                $result[] = $item;
                $sublevelData = self::flat($item->id,$level+1);
                if (!empty($sublevelData)) {
                    $result = array_merge($result, $sublevelData);
                }
            }
        }

        return $result;
    }

    public static function children($id, $subchild=false, $firstNew = false)
    {
        $order = 'asc';
        if ($firstNew) {
            $order = 'desc';
        }

        $result = [];
        $data = self::where('parent_id',$id)->orderBy('created_at',$order)->get();

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
