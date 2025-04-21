<?php

namespace Elfcms\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Elfcms\Blog\Models\Blog;
use Elfcms\Blog\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogNavigator extends Controller
{
    public function index(Request $request)
    {

        $message = null;

        if ($request->session()->has('categoryresult')) {
            $message = [
                'type' => 'alternate',
                'header' => '&nbsp;',
                'text' => Session::get('categoryresult'),
            ];
        } elseif ($request->session()->has('postresult')) {
            $message = [
                'type' => 'alternate',
                'header' => '&nbsp;',
                'text' => Session::get('postresult'),
            ];
        } elseif ($request->session()->has('errors')) {
            $text = '';
            foreach ($request->session()->get('errors')->getBags()['default']->toArray() as $key => $errors) {
                foreach ($errors as $error) {
                    $text .= '<li>' . $error . '</li>';
                }
            }
            $message = [
                'type' => 'danger',
                'header' => __('elfcms::default.errors'),
                'text' => '<ul>' . $text . '</ul>',
            ];
        }

        $blogs = Blog::all();

        $blog = Blog::where('slug', $request->blog)->first() ?? new Blog();

        $category = BlogCategory::where('slug', $request->category)->first() ?? null;

        if ($category) {
            $categories = $category->categories ?? [];
        } else {
            $categories = $blog->topCategories ?? [];
        }

        return view('elfcms::admin.blog.nav.index', [
            'page' => [
                'title' => empty($blog->id) ? __('blog::default.blogs') : /* __('blog::default.blog') . ': ' . */ $blog->name,
                'current' => url()->current(),
            ],
            'blogs' => $blogs,
            'blog' => $blog,
            'category' => $category,
            'categories' => $categories,
            'message' => $message
        ]);
    }
}
