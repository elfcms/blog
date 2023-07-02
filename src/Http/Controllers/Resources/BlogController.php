<?php

namespace Elfcms\Blog\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Elfcms\Blog\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
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
        //$categories = BlogCategory::where('parent_id',null)->get();
        if (!empty($search)) {
            $blogs = Blog::where('name','like',"%{$search}%")->orderBy($order, $trend)->paginate($count);
        }
        else {
            $blogs = Blog::orderBy($order, $trend)->paginate($count);
        }

        return view('blog::admin.blog.blogs.index',[
            'page' => [
                'title' => 'Blogs',
                'current' => url()->current(),
            ],
            'blogs' => $blogs,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog::admin.blog.blogs.create',[
            'page' => [
                'title' => __('blog::elf.create_blog'),
                'current' => url()->current(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'slug' => Str::slug($request->slug),
        ]);
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:Elfcms\Blog\Models\Blog,slug',
            'image' => 'nullable|file|max:512',
            'preview' => 'nullable|file|max:256'
        ]);

        $image_path = '';
        $preview_path = '';
        if (!empty($request->file()['image'])) {
            $image = $request->file()['image']->store('public/blog/blogs/image');
            $image_path = str_ireplace('public/','/storage/',$image);
        }
        if (!empty($request->file()['preview'])) {
            $preview = $request->file()['preview']->store('public/blog/blogs/preview');
            $preview_path = str_ireplace('public/','/storage/',$preview);
        }

        $validated['image'] = $image_path;
        $validated['preview'] = $preview_path;
        $validated['description'] = $request->description;
        $validated['active'] = empty($request->active) ? 0 : 1;
        $validated['meta_keywords'] = $request->meta_keywords;
        $validated['meta_description'] = $request->meta_description;

        $blog = Blog::create($validated);

        return redirect(route('admin.blog.blogs.edit',$blog->id))->with('result','Blog created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $blog->created = '';
        $blog->updated = '';
        if (!empty($blog->created_at)) {
            $blog->created = date('d.m.Y H:i:s',strtotime($blog->created_at));
        }
        if (!empty($blog->updated_at)) {
            $blog->updated = date('d.m.Y H:i:s',strtotime($blog->updated_at));
        }
        return view('blog::admin.blog.blogs.edit',[
            'page' => [
                'title' => 'Edit blog #' . $blog->id,
                'current' => url()->current(),
            ],
            'blog' => $blog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        if ($request->notedit && $request->notedit == 1) {
            $blog->active = empty($request->active) ? 0 : 1;

            $blog->save();

            return redirect(route('admin.blog.blogs'))->with('result','Blog edited successfully');
        }
        else {
            $request->merge([
                'slug' => Str::slug($request->slug),
            ]);
            $validated = $request->validate([
                'name' => 'required',
                //'slug' => 'required|unique:Elfcms\Blog\Models\BlogCategory,slug',
                'slug' => 'required',
                'image' => 'nullable|file|max:512',
                'preview' => 'nullable|file|max:256'
            ]);
            if (Blog::where('slug',$request->slug)->where('id','<>',$blog->id)->first()) {
                return redirect(route('admin.blog.blogs.edit'))->withErrors([
                    'slug' => 'Blog already exists'
                ]);
            }
            $image_path = $request->image_path;
            $preview_path = $request->preview_path;
            if (!empty($request->file()['image'])) {
                $image = $request->file()['image']->store('public/blog/blogs/image');
                $image_path = str_ireplace('public/','/storage/',$image);
            }
            if (!empty($request->file()['preview'])) {
                $preview = $request->file()['preview']->store('public/blog/blogs/preview');
                $preview_path = str_ireplace('public/','/storage/',$preview);
            }

            $blog->name = $validated['name'];
            $blog->slug = $validated['slug'];
            $blog->image = $image_path;
            $blog->preview = $preview_path;
            $blog->description = $request->description;
            $blog->active = empty($request->active) ? 0 : 1;
            $blog->meta_keywords = $request->meta_keywords;
            $blog->meta_description = $request->meta_description;

            $blog->save();

            return redirect(route('admin.blog.blogs.edit',$blog->id))->with('result','Blog edited successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if (!$blog->delete()) {
            return redirect(route('admin.blog.blogs'))->withErrors(['delerror'=>'Error of blog deleting']);
        }

        return redirect(route('admin.blog.categories'))->with('result','Blog deleted successfully');
    }
}
