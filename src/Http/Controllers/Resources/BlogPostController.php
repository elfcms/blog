<?php

namespace Elfcms\Blog\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Elfcms\Blog\Models\Blog;
use Elfcms\Blog\Models\BlogCategory;
use Elfcms\Blog\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = null;

        $trend = 'asc';
        $order = 'id';
        if (!empty($request->trend) && $request->trend == 'desc') {
            $trend = 'desc';
        }
        if (!empty($request->order)) {
            $order = $request->order;
        }
        $search = $request->search ?? '';
        if (!empty($request->category)) {
            $posts = BlogPost::where('category_id', $request->category)->orderBy($order, $trend)->paginate(30);

            $category = BlogCategory::find($request->category);
        } elseif (!empty($search)) {
            $posts = BlogPost::where('name', 'like', "%{$search}%")->orderBy($order, $trend)->paginate(30);
        } else {
            $posts = BlogPost::orderBy($order, $trend)->paginate(30);
        }

        $categories = BlogCategory::all();
        $blogs = Blog::all();

        return view('elfcms::admin.blog.posts.index', [
            'page' => [
                'title' => 'Posts',
                'current' => url()->current(),
            ],
            'posts' => $posts,
            'category' => $category,
            'params' => $request->all(),
            'search' => $search,
            'categories' => $categories,
            'blogs' => $blogs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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

        $fields = $request->old();

        if (empty($fields)) {
            $form = new BlogPost();
            $fillables = $form->getFillable();
            foreach ($fillables as $field) {
                $fields[$field] = '';
            }
        }

        $navParams = ['blog' => $currentBlog];
        if (!empty($curentCategory)) {
            $navParams['category'] = $curentCategory;
        }

        return view('elfcms::admin.blog.posts.create', [
            'page' => [
                'title' => 'Create post',
                'current' => url()->current(),
            ],
            'categories' => $categories,
            'blogs' => $blogs,
            'currentBlog' => $currentBlog,
            'firstBlog' => $firstBlog,
            'category_id' => $category_id,
            'fields' => $fields,
            'navParams' => $navParams,
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
            //'category_id' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:Elfcms\Blog\Models\BlogPost,slug',
            'image' => 'nullable|file|max:' . config('elfcms.blog.files.max_size.image') ?? 1024,
            'preview' => 'nullable|file|max:' . config('elfcms.blog.files.max_size.preview') ?? 768
        ]);

        $image_path = '';
        $preview_path = '';
        if (!empty($request->file()['image'])) {
            $image_path = $request->file()['image']->store('blog/posts/image');
        }
        if (!empty($request->file()['preview'])) {
            $preview_path = $request->file()['preview']->store('blog/posts/preview');
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

        $validated['category_id'] = $request->category_id ?? null;
        $validated['blog_id'] = $request->blog_id ?? null;
        $validated['image'] = $image_path;
        $validated['preview'] = $preview_path;
        $validated['description'] = $request->description;
        $validated['text'] = $request->text;
        $validated['active'] = empty($request->active) ? 0 : 1;
        $validated['public_time'] = $public_time;
        $validated['end_time'] = $end_time;
        $validated['meta_keywords'] = $request->meta_keywords;
        $validated['meta_description'] = $request->meta_description;

        $post = BlogPost::create($validated);

        if (!empty($request->tags)) {
            foreach ($request->tags as $tagId) {
                $post->tags()->attach($tagId);
            }
        }
        if (!empty($request->category_id)) {
            $post->categories()->attach($request->category_id);
        }

        $navParams = ['blog' => $post->blog];
        if (!empty($post->category)) {
            $navParams['category'] = $post->category;
        }

        if ($request->input('submit') == 'save_and_close') {
            return redirect(route('admin.blog.nav', $navParams))->with('success', __('blog::default.post_created_successfully'));
        }

        return redirect(route('admin.blog.posts.edit', $post))->with('success', __('blog::default.post_created_successfully'));
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
    public function edit(BlogPost $post, Request  $request)
    {
        if (!empty($post->end_time)) {
            $post->end_time_time = date('H:i', strtotime($post->end_time));
            $post->end_time = date('Y-m-d', strtotime($post->end_time));
        }
        if (!empty($post->public_time)) {
            $post->public_time_time = date('H:i', strtotime($post->public_time));
            $post->public_time = date('Y-m-d', strtotime($post->public_time));
        }
        $post->created = '';
        $post->updated = '';
        if (!empty($post->created_at)) {
            $post->created = date('d.m.Y H:i:s', strtotime($post->created_at));
        }
        if (!empty($post->updated_at)) {
            $post->updated = date('d.m.Y H:i:s', strtotime($post->updated_at));
        }
        $categories = BlogCategory::all();
        $postCategories = [];
        foreach ($post->categories as $category) {
            $postCategories[] = $category->id;
        }
        $blogs = Blog::all();

        $navParams = ['blog' => $post->blog];
        if (!empty($post->category)) {
            $navParams['category'] = $post->category;
        }

        return view('elfcms::admin.blog.posts.edit', [
            'page' => [
                'title' => 'Edit post #' . $post->id,
                'current' => url()->current(),
            ],
            'post' => $post,
            'categories' => $categories,
            'blogs' => $blogs,
            'postCategories' => $postCategories,
            'navParams' => $navParams,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogPost $post)
    {
        if ($request->notedit && $request->notedit == 1) {
            $post->active = empty($request->active) ? 0 : 1;

            $post->save();

            return redirect(route('admin.blog.posts'))->with('success', 'Post edited successfully');
        } else {
            $request->merge([
                'slug' => Str::slug($request->slug),
            ]);
            $validated = $request->validate([
                'name' => 'required',
                'image' => 'nullable|file|max:' . config('elfcms.blog.files.max_size.image') ?? 1024,
                'preview' => 'nullable|file|max:' . config('elfcms.blog.files.max_size.preview') ?? 768
            ]);
            if (BlogPost::where('slug', $request->slug)->where('id', '<>', $post->id)->first()) {
                return redirect(route('admin.blog.posts.edit', $post->id))->withErrors([
                    'slug' => 'Post already exists'
                ]);
            }

            $image_path = $request->image_path;
            $preview_path = $request->preview_path;
            if (!empty($request->file()['image'])) {
                $image_path = $request->file()['image']->store('blog/posts/image');
            }
            if (!empty($request->file()['preview'])) {
                $preview_path = $request->file()['preview']->store('blog/posts/preview');
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

            $post->blog_id = $request->blog_id ?? null;
            $post->name = $validated['name'];
            $post->slug = $request->slug;
            $post->image = $image_path;
            $post->preview = $preview_path;
            $post->description = $request->description;
            $post->text = $request->text;
            $post->active = empty($request->active) ? 0 : 1;
            $post->public_time = $public_time;
            $post->end_time = $end_time;
            $post->meta_keywords = $request->meta_keywords;
            $post->meta_description = $request->meta_description;

            $post->categories()->sync($request->categories ?? []);

            $existTags = $post->tags->toArray();

            $newTags = $request->tags ? $request->tags : [];

            if (!empty($existTags)) {
                foreach ($existTags as $existTag) {
                    if (!in_array($existTag['id'], $newTags)) {
                        $post->tags()->detach($existTag['id']);
                    } else {
                        $key = array_search($existTag['id'], $newTags);
                        unset($newTags[$key]);
                    }
                }
            }
            if (!empty($newTags)) {
                foreach ($newTags as $tagId) {
                    $post->tags()->attach($tagId);
                }
            }

            $post->save();

            $navParams = ['blog' => $post->blog];
            if (!empty($post->category)) {
                $navParams['category'] = $post->category;
            }

            if ($request->input('submit') == 'save_and_close') {
                return redirect(route('admin.blog.nav',$navParams))->with('success', __('blog::default.post_edited_successfully'));
            }

            return redirect(route('admin.blog.posts.edit', $post))->with('success', __('blog::default.post_edited_successfully'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $post)
    {
        if (!$post->delete()) {
            return redirect(route('admin.blog.posts'))->withErrors(['postdelerror' => __('blog::default.error_of_post_deleted')]);
        }

        return redirect(route('admin.blog.posts'))->with('success', __('blog::default.post_deleted_successfully'));
    }
}
