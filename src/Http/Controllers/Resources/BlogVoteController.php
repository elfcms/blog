<?php

namespace Elfcms\Blog\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Elfcms\Blog\Models\BlogPost;
use Elfcms\Blog\Models\BlogVote;
use Elfcms\Basic\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return BlogVote::all()->toJson();
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
            $votes = BlogVote::where('post_id',$request->post)->orderBy($order, $trend)->paginate(30);

            $post = BlogPost::find($request->post);
        }
        elseif (!empty($request->user)) {
            $votes = BlogVote::where('user_id',$request->user)->orderBy($order, $trend)->paginate(30);

            $user = User::find($request->user);
        }
        else {
            $votes = BlogVote::orderBy($order, $trend)->paginate(30);

        }

        return view('admin.blog.votes.index',[
            'page' => [
                'title' => 'Votes',
                'current' => url()->current(),
            ],
            'votes' => $votes,
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
        $votes = BlogVote::all();
        return view('admin.blog.votes.create',[
            'page' => [
                'title' => 'Create comment',
                'current' => url()->current(),
            ],
            'posts' => $posts,
            'votes' => $votes,
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
        if (!empty($userId)) {
            $checkVote = BlogVote::where('user_id',$userId)->where('post_id',$request->post_id)->first();
            //dd($checkVote);
        }
        if ($checkVote) {
            $checkVote->post_id = $validated['post_id'];
            $checkVote->value = $validated['value'];

            $checkVote->save();

            if ($request->ajax()) {
                return BlogPost::find($validated['post_id'])->getVote();
            }

            return redirect(route('admin.blog.votes.edit',$checkVote->id))->with('voteedited','Vote edited successfully');
        }

        $validated['user_id'] = $userId;

        $vote = BlogVote::create($validated);

        if ($request->ajax()) {
            return BlogPost::find($validated['post_id'])->getVote();
        }

        return redirect(route('admin.blog.votes.edit',$vote->id))->with('votecreated','Vote created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BlogVote $vote, Request $request)
    {
        if ($request->ajax()) {
            return $vote->toJson();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogVote $vote)
    {
        $posts = BlogPost::all();
        return view('admin.blog.votes.edit',[
            'page' => [
                'title' => 'Edit vote',
                'current' => url()->current(),
            ],
            'posts' => $posts,
            'vote' => $vote,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogVote $vote)
    {
        $validated = $request->validate([
            'post_id' => 'required',
            'value' => 'required'
        ]);

        $vote->post_id = $validated['post_id'];
        $vote->value = $validated['value'];

        $vote->save();

        return redirect(route('admin.blog.votes.edit',$vote->id))->with('voteedited','Vote edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogVote $vote)
    {
        if (!$vote->delete()) {
            return redirect(route('admin.blog.votes'))->withErrors(['votedelerror'=>'Error of vote deleting']);
        }

        return redirect(route('admin.blog.votes'))->with('votedeleted','Vote deleted successfully');
    }
}
