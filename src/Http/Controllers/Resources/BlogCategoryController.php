<?php

namespace Elfcms\Blog\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Elfcms\Blog\Models\Blog;
use Elfcms\Blog\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trend = 'asc';
        $order = 'id';
        if (!empty($request->trend) && $request->trend == 'desc') {
            $trend = 'desc';
        }
        if (!empty($request->order)) {
            $order = $request->order;
        }
        if (!empty($request->count)) {
            $count = intval($request->count);
        }
        if (empty($count)) {
            $count = 30;
        }
        $search = $request->search ?? '';

        if (!empty($search)) {
            $categories = BlogCategory::where('name', 'like', "%{$search}%")->orderBy($order, $trend)->paginate($count);
        } else {
            $categories = BlogCategory::flat(trend: $trend, order: $order, count: $count, search: $search);
        }

        return view('elfcms::admin.blog.categories.index', [
            'page' => [
                'title' => 'Blog categories',
                'current' => url()->current(),
            ],
            'categories' => $categories,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        $category_id = null;
        $categories = BlogCategory::all();
        $blogs = Blog::active()->get();
        $currentBlog = Blog::where('id', $request->blog)->orWhere('slug', $request->blog)->first();
        $firstBlog = Blog::active()->first();
        if (!empty($request->category_id)) {
            $curentCategory = BlogCategory::find($request->category_id);
            if ($curentCategory) {
                $category_id = $request->category_id;
                if (empty($request->blog)) {
                    $currentBlog = $curentCategory->blog;
                }
            }
        }

        return view('elfcms::admin.blog.categories.create', [
            'page' => [
                'title' => 'Create category',
                'current' => url()->current(),
            ],
            'categories' => $categories,
            'blogs' => $blogs,
            'currentBlog' => $currentBlog,
            'firstBlog' => $firstBlog,
            'category_id' => $category_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'slug' => Str::slug($request->slug),
        ]);
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:Elfcms\Blog\Models\BlogCategory,slug',
            'image' => 'nullable|file|max:' . config('elfcms.blog.files.max_size.image') ?? 1024,
            'preview' => 'nullable|file|max:' . config('elfcms.blog.files.max_size.preview') ?? 768
        ]);

        $image_path = '';
        $preview_path = '';
        if (!empty($request->file()['image'])) {
            $image = $request->file()['image']->store('public/elfcms/blog/categories/image');
            $image_path = str_ireplace('public/', '/storage/', $image);
        }
        if (!empty($request->file()['preview'])) {
            $preview = $request->file()['preview']->store('public/elfcms/blog/categories/preview');
            $preview_path = str_ireplace('public/', '/storage/', $preview);
        }

        $public_time = $request->public_time[0];

        if (empty($request->public_time[1]) && !empty($public_time)) {
            $public_time .= ' 00:00:00';
        } elseif (!empty($public_time)) {
            $public_time .= ' ' . $request->public_time[1];
        }

        $end_time = $request->end_time[0];

        if (empty($request->end_time[1]) && !empty($end_time)) {
            $end_time .= ' 00:00:00';
        } elseif (!empty($end_time)) {
            $end_time .= ' ' . $request->end_time[1];
        }

        $validated['blog_id'] = $request->blog_id ?? null;
        $validated['image'] = $image_path;
        $validated['preview'] = $preview_path;
        $validated['description'] = $request->description;
        $validated['active'] = empty($request->active) ? 0 : 1;
        $validated['public_time'] = $public_time;
        $validated['end_time'] = $end_time;
        $validated['parent_id'] = $request->parent_id;
        $validated['meta_keywords'] = $request->meta_keywords;
        $validated['meta_description'] = $request->meta_description;

        $category = BlogCategory::create($validated);

        return redirect(route('admin.blog.categories.edit', $category))->with('categorycreated', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogCategory $category, Request  $request)
    {
        if (!empty($category->end_time)) {
            $category->end_time_time = date('H:i', strtotime($category->end_time));
            $category->end_time = date('Y-m-d', strtotime($category->end_time));
        }
        if (!empty($category->public_time)) {
            $category->public_time_time = date('H:i', strtotime($category->public_time));
            $category->public_time = date('Y-m-d', strtotime($category->public_time));
        }
        $category->created = '';
        $category->updated = '';
        if (!empty($category->created_at)) {
            $category->created = date('d.m.Y H:i:s', strtotime($category->created_at));
        }
        if (!empty($category->updated_at)) {
            $category->updated = date('d.m.Y H:i:s', strtotime($category->updated_at));
        }
        $exclude = BlogCategory::childrenid($category->id, true);
        $categories = BlogCategory::whereNotIn('id', $exclude)->get();
        $blogs = Blog::all();
        return view('elfcms::admin.blog.categories.edit', [
            'page' => [
                'title' => 'Edit category #' . $category->id,
                'current' => url()->current(),
            ],
            'category' => $category,
            'categories' => $categories,
            'blogs' => $blogs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogCategory $category)
    {
        if ($request->notedit && $request->notedit == 1) {
            $category->active = empty($request->active) ? 0 : 1;

            $category->save();

            return redirect(route('admin.blog.categories'))->with('categoryedited', 'Category edited successfully');
        } else {
            $request->merge([
                'slug' => Str::slug($request->slug),
            ]);
            $validated = $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'image' => 'nullable|file|max:' . config('elfcms.blog.files.max_size.image') ?? 1024,
                'preview' => 'nullable|file|max:' . config('elfcms.blog.files.max_size.preview') ?? 768
            ]);
            if (BlogCategory::where('slug', $request->slug)->where('id', '<>', $category->id)->first()) {
                return redirect(route('admin.blog.categories.edit'))->withErrors([
                    'slug' => 'Category already exists'
                ]);
            }
            $image_path = $request->image_path;
            $preview_path = $request->preview_path;
            if (!empty($request->file()['image'])) {
                $image = $request->file()['image']->store('public/blog/categories/image');
                $image_path = str_ireplace('public/', '/storage/', $image);
            }
            if (!empty($request->file()['preview'])) {
                $preview = $request->file()['preview']->store('public/blog/categories/preview');
                $preview_path = str_ireplace('public/', '/storage/', $preview);
            }

            $public_time = $request->public_time[0];

            if (empty($request->public_time[1]) && !empty($public_time)) {
                $public_time .= ' 00:00:00';
            } elseif (!empty($public_time)) {
                $public_time .= ' ' . $request->public_time[1];
            }

            $end_time = $request->end_time[0];

            if (empty($request->end_time[1]) && !empty($end_time)) {
                $end_time .= ' 00:00:00';
            } elseif (!empty($end_time)) {
                $end_time .= ' ' . $request->end_time[1];
            }

            $category->name = $validated['name'];
            $category->slug = $validated['slug'];
            $category->blog_id = $request->blog_id ?? null;
            $category->parent_id = $request->parent_id;
            $category->image = $image_path;
            $category->preview = $preview_path;
            $category->description = $request->description;
            $category->active = empty($request->active) ? 0 : 1;
            $category->public_time = $public_time;
            $category->end_time = $end_time;
            $category->meta_keywords = $request->meta_keywords;
            $category->meta_description = $request->meta_description;

            $category->save();

            return redirect(route('admin.blog.categories.edit', $category))->with('categoryedited', 'Category edited successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogCategory $category)
    {
        if (!$category->delete()) {
            return redirect(route('admin.blog.categories'))->withErrors(['categorydelerror' => 'Error of category deleting']);
        }

        return redirect(route('admin.blog.categories'))->with('categorydeleted', 'Category deleted successfully');
    }
}
