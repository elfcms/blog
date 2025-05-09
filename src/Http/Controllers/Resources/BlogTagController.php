<?php

namespace Elfcms\Blog\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Elfcms\Blog\Models\BlogTag;
use Illuminate\Http\Request;

class BlogTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return BlogTag::all()->toJson();
        }
        $trend = 'asc';
        $order = 'id';
        if (!empty($request->trend) && $request->trend == 'desc') {
            $trend = 'desc';
        }
        if (!empty($request->order)) {
            $order = $request->order;
        }
        $tags = BlogTag::orderBy($order, $trend)->paginate(30);

        return view('elfcms::admin.blog.tags.index', [
            'page' => [
                'title' => __('blog::default.tags'),
                'current' => url()->current(),
            ],
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('elfcms::admin.blog.tags.create', [
            'page' => [
                'title' => __('blog::default.tag'),
                'current' => url()->current(),
            ],
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
        $validated = $request->validate([
            'name' => 'required|unique:Elfcms\Blog\Models\BlogTag,name'
        ]);
        $tag = BlogTag::create($validated);

        if ($request->ajax()) {
            $result = 'error';
            $message = __('blog::default.error_of_tag_created');
            $data = [];
            if ($tag) {
                $result = 'success';
                $message = __('blog::default.tag_created_successfully');
                $data = ['id' => $tag->id];
            }
            return json_encode(['result' => $result, 'message' => $message, 'data' => $data]);
        }

        //return redirect(route('admin.blog.tags.edit', $tag->id))->with('success', __('blog::default.tag_created_successfully'));
        return redirect(route('admin.blog.tags'))->with('success', __('blog::default.tag_created_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BlogTag $tag, Request $request)
    {
        if ($request->ajax()) {
            return BlogTag::find($tag->id)->toJson();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogTag $tag)
    {

        return view('elfcms::admin.blog.tags.edit', [
            'page' => [
                'title' => __('blog::default.edit_tag'),
                'current' => url()->current(),
            ],
            'tag' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogTag $tag)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        if (BlogTag::where('name', $validated['name'])->where('id', '<>', $tag->id)->first()) {
            return redirect(route('admin.blog.tags.edit', $tag->id))->withErrors([
                'name' => 'Tag already exists'
            ]);
        }

        $tag->name = $validated['name'];
        $tag->save();

        //return redirect(route('admin.blog.tags.edit', $tag->id))->with('success', __('blog::default.tag_edited_successfully'));
        return redirect(route('admin.blog.tags'))->with('success', __('blog::default.tag_edited_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogTag $tag)
    {
        if (!$tag->delete()) {
            return redirect(route('admin.blog.tags'))->withErrors(['tagdelerror' => 'Error of tag deleting']);
        }

        return redirect(route('admin.blog.tags'))->with('success', 'Tag deleted successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addNotExist(Request $request)
    {
        if ($request->ajax()) {
            $validated = $request->validate([
                'name' => 'required'
            ]);

            $result = 'error';
            $message = __('blog::default.error_of_tag_created');
            $data = [];

            if ($tagByName = BlogTag::where('name', $validated['name'])->first()) {
                $result = 'exist';
                $message = 'Tag already exist';
                $data = ['id' => $tagByName->id, 'name' => $tagByName->name];
            } else {
                $tag = BlogTag::create($validated);

                if ($tag) {
                    $result = 'success';
                    $message = __('blog::default.tag_created_successfully');
                    $data = ['id' => $tag->id, 'name' => $validated['name']];
                }
            }

            return json_encode(['result' => $result, 'message' => $message, 'data' => $data]);
        }
    }
}
