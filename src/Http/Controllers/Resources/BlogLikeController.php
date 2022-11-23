<?php

namespace Elfcms\Blog\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Elfcms\Blog\Models\BlogPost;
use Elfcms\Blog\Models\BlogLike;
use Elfcms\Basic\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return BlogLike::all()->toJson();
        }


        $post = null;
        $user = null;

        $trend = 'asc';
        $order = 'id';
        if (!empty($request->trend) && $request->trend == 'desc') {
            $trend = 'desc';
        }
        if (!empty($request->order)) {
            $order = $request->order;
        }
        if (!empty($request->post)) {
            $likes = BlogLike::where('post_id',$request->post)->orderBy($order, $trend)->paginate(30);

            $post = BlogPost::find($request->post);
        }
        elseif (!empty($request->user)) {
            $likes = BlogLike::where('user_id',$request->user)->orderBy($order, $trend)->paginate(30);

            $user = User::find($request->user);
        }
        else {
            $likes = BlogLike::orderBy($order, $trend)->paginate(30);

        }

        return view('blog::admin.blog.likes.index',[
            'page' => [
                'title' => 'likes',
                'current' => url()->current(),
            ],
            'likes' => $likes,
            'post' => $post,
            'user' => $user,
            'params' => $request->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $posts = BlogPost::all();
        $likes = BlogLike::all();
        return view('blog::admin.blog.likes.create',[
            'page' => [
                'title' => 'Create comment',
                'current' => url()->current(),
            ],
            'posts' => $posts,
            'likes' => $likes,
            'post_id' => $request->post_id,
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
        $userId = null;
        if (Auth::check()) {
            $userId = Auth::user()->id;
        }
        $validated = $request->validate([
            'post_id' => 'required',
            'value' => 'required'
        ]);
        if ($validated['value'] > 0) {
            $validated['value'] = 1;
        }
        elseif ($validated['value'] < 0) {
            $validated['value'] = -1;
        }
        if (!empty($userId)) {
            $checklike = BlogLike::where('user_id',$userId)->where('post_id',$request->post_id)->first();
            //dd($checklike);

        }
        if ($checklike) {

            if ($checklike->value == $validated['value']) {
                $validated['value'] = 0;
            }

            $checklike->post_id = $validated['post_id'];
            $checklike->value = $validated['value'];

            $checklike->save();

            if ($request->ajax()) {
                return BlogPost::find($validated['post_id'])->getLike();
            }

            return redirect(route('admin.blog.likes.edit',$checklike->id))->with('likeedited','like edited successfully');
        }

        $validated['user_id'] = $userId;

        $like = BlogLike::create($validated);

        if ($request->ajax()) {
            return BlogPost::find($validated['post_id'])->getLike();
        }

        return redirect(route('admin.blog.likes.edit',$like->id))->with('likecreated','like created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BlogLike $like, Request $request)
    {
        if ($request->ajax()) {
            return $like->toJson();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogLike $like)
    {
        $posts = BlogPost::all();
        return view('blog::admin.blog.likes.edit',[
            'page' => [
                'title' => 'Edit like',
                'current' => url()->current(),
            ],
            'posts' => $posts,
            'like' => $like,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogLike $like)
    {
        $validated = $request->validate([
            'post_id' => 'required',
            'value' => 'required'
        ]);

        if ($validated['value'] > 0) {
            $validated['value'] = 1;
        }
        elseif ($validated['value'] < 0) {
            $validated['value'] = -1;
        }

        $like->post_id = $validated['post_id'];
        $like->value = $validated['value'];

        $like->save();

        return redirect(route('admin.blog.likes.edit',$like->id))->with('likeedited','like edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogLike $like)
    {
        if (!$like->delete()) {
            return redirect(route('admin.blog.likes'))->withErrors(['likedelerror'=>'Error of like deleting']);
        }

        return redirect(route('admin.blog.likes'))->with('likedeleted','like deleted successfully');
    }
}
