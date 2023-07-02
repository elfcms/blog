<?php

namespace Elfcms\Infobox\Http\Controllers;

use App\Http\Controllers\Controller;
use Elfcms\Blog\Models\BlogCategory;
use Elfcms\Blog\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogNavigator extends Controller
{
    public function index(Request $request)
    {

        //dd(Session::get('postresult'));
        //dd($request->session());
        //dd(Session::get('errors')->getBags()['default']);
        //dd($request->session()->get('errors')->getBags()['default']->toArray());

        /* $trend = 'asc';
        $order = 'id';
        if (!empty($request->trend) && $request->trend == 'desc') {
            $trend = 'desc';
        }
        if (!empty($request->order)) {
            $order = $request->order;
        }
        $search = $request->search ?? '';
        if (!empty($search)) {
            $posts = Infobox::where('title','like',"%{$search}%")->orderBy($order, $trend)->paginate(30);

        }
        else {
            $posts = Infobox::orderBy($order, $trend)->paginate(30);

        } */
        $message = null;

        if ($request->session()->has('postresult')) {
            $message = [
                'type' => 'alternate',
                'header' => '&nbsp;',
                'text' => Session::get('postresult'),
            ];
        }
        elseif ($request->session()->has('itemresult')) {
            $message = [
                'type' => 'alternate',
                'header' => '&nbsp;',
                'text' => Session::get('itemresult'),
            ];
        }
        elseif ($request->session()->has('errors')) {
            $text = '';
            foreach ($request->session()->get('errors')->getBags()['default']->toArray() as $key => $errors) {
                foreach ($errors as $error) {
                    $text .= '<li>'. $error .'</li>';
                }
            }
            $message = [
                'type' => 'danger',
                'header' => __('basic::elf.errors'),
                'text' => '<ul>' . $text . '</ul>',
            ];
        }

        $posts = BlogCategory::orderBy('title')->get();

        $category = BlogCategory::where('slug', $request->category)->first() ?? $posts[0] ?? null;

        $post = BlogPost::where('slug', $request->post)->first() ?? null;

        if ($post) {
            $posts = $post->posts;
        }
        else {
            $posts = $category->topCategories;
        }

        /* $c = InfoboxCategory::find(6);

        dd($c->parentsId()); */

        //dd(InfoboxCategory::where('category_id', $category->id)->get()[0]->subtree());
        //dd(InfoboxCategory::flat()->where('category_id', $category->id));
        //dd($category->posts[0]->posts);
        //dd($category->topCategories);

        /* $pageTitle = __('category::elf.category') . ': ' . $category->title;

        if ($post) {
            $pageTitle .= ' | ' . __('category::elf.post') . ': ' . $post->title . ' sdfdsgdfsgsdf sdg sdfgsdf sdf gsfdgfdg';
        } */

        return view('blog::admin.category.nav.index',[
            'page' => [
                'title' => __('blog::elf.category') . ': ' . $category->title,
                'current' => url()->current(),
            ],
            'posts' => $posts,
            'category' => $category,
            'post' => $post,
            'posts' => $posts,
            'message' => $message
        ]);
    }
}
