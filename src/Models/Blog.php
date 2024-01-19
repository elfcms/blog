<?php

namespace Elfcms\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'image',
        'preview',
        'description',
        'active',
        'meta_keywords',
        'meta_description'
    ];

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

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'blog_id');
    }

    public function topPosts()
    {
        return $this->hasMany(BlogPost::class, 'blog_id')->where('category_id', null);
    }

    public function categories()
    {
        return $this->hasMany(BlogCategory::class, 'blog_id');
    }

    public function topCategories()
    {
        return $this->hasMany(BlogCategory::class, 'blog_id')->where('parent_id', null)->orderBy('position');
    }

    public function categoriesFull()
    {
        return $this->hasMany(BlogCategory::class, 'blog_id')->with('posts');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id');
    }
}
