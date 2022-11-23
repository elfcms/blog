<?php

namespace Elfcms\Blog\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Elfcms\Blog\Models\BlogComment;
use Elfcms\Blog\Models\BlogPost;
use Elfcms\Basic\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return BlogComment::all()->toJson();
        }


        $post = null;
        $parent = null;
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
            $comments = BlogComment::where('post_id',$request->post)->orderBy($order, $trend)->paginate(30);

            $post = BlogPost::find($request->post);
        }
        elseif (!empty($request->user)) {
            $comments = BlogComment::where('user_id',$request->user)->orderBy($order, $trend)->paginate(30);

            $user = User::find($request->user);
        }
        elseif (!empty($request->parent)) {
            $comments = BlogComment::where('parent_id',$request->parent)->orderBy($order, $trend)->paginate(30);

            $parent = BlogComment::find($request->parent);
        }
        else {
            $comments = BlogComment::orderBy($order, $trend)->paginate(30);

        }

        return view('blog::admin.blog.comments.index',[
            'page' => [
                'title' => 'Comments',
                'current' => url()->current(),
            ],
            'comments' => $comments,
            'post' => $post,
            'parent' => $parent,
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
        $comments = BlogComment::all();
        return view('blog::admin.blog.comments.create',[
            'page' => [
                'title' => 'Create comment',
                'current' => url()->current(),
            ],
            'posts' => $posts,
            'comments' => $comments,
            'post_id' => $request->post_id,
            'parent_id' => $request->parent_id
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
        //dd($request->parent_id);
        $validated = $request->validate([
            'post_id' => 'required',
            'text' => 'required'
        ]);
        $userId = null;
        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $validated['user_id'] = $userId;
        $validated['parent_id'] = $request->parent_id && $request->parent_id != 'null' ? $request->parent_id : null;
        $validated['active'] = empty($request->active) ? 0 : 1;

        $comment = BlogComment::create($validated);

        if ($request->ajax()) {
            $userName = $comment->user->name(true);
            $comment->userName = $userName;
            return $comment;
        }

        return redirect(route('admin.blog.comments.edit',$comment->id))->with('commentcreated','Comment created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BlogComment $comment, Request $request)
    {
        if ($request->ajax()) {
            return $comment->toJson();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogComment $comment)
    {
        $posts = BlogPost::all();
        $comments = BlogComment::all();
        return view('blog::admin.blog.comments.edit',[
            'page' => [
                'title' => 'Edit comment',
                'current' => url()->current(),
            ],
            'posts' => $posts,
            'comments' => $comments,
            'comment' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogComment $comment)
    {
        if ($request->notedit && $request->notedit == 1) {
            $comment->active = empty($request->active) ? 0 : 1;

            $comment->save();

            return redirect(route('admin.blog.comments'))->with('commentedited','Comment edited successfully');
        }
        $validated = $request->validate([
            'post_id' => 'required',
            'text' => 'required'
        ]);

        $comment->post_id = $validated['post_id'];
        $comment->text = $validated['text'];
        $comment->parent_id = $request->parent_id && $request->parent_id != 'null' ? $request->parent_id : null;
        $comment->active = empty($request->active) ? 0 : 1;

        $comment->save();

        return redirect(route('admin.blog.comments.edit',$comment->id))->with('commentedited','Comment edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogComment $comment)
    {
        if (!$comment->delete()) {
            return redirect(route('admin.blog.comments'))->withErrors(['commentdelerror'=>'Error of comment deleting']);
        }

        return redirect(route('admin.blog.comments'))->with('commentdeleted','Comment deleted successfully');
    }
}
