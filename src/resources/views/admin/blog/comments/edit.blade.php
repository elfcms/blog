@extends('elfcms::admin.layouts.blog')

@section('blogpage-content')

    @if (Session::has('commentedited'))
        <div class="alert alert-success">{{ Session::get('commentedited') }}</div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="errors-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="post-form">
        <h3>{{ __('blog::default.edit_comment') }}</h3>
        <form action="{{ route('admin.blog.comments.update',$comment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <x-elfcms-input-checkbox code="active" label="{{ __('elfcms::default.active') }}" style="blue" :checked="$comment->active" />
                </div>
                <div class="input-box colored">
                    <label for="post_id">{{ __('elfcms::default.post') }}</label>
                    <div class="input-wrapper">
                        {{-- <select name="post_id" id="post_id">
                        @foreach ($posts as $post)
                            <option value="{{ $post->id }}" @if ($post->active != 1) class="inactive" @endif @if ($post->id == $comment->post_id) selected @endif>{{ $post->name }}@if ($post->active != 1) [{{ __('elfcms::default.inactive') }}] @endif</option>
                        @endforeach
                        </select> --}}
                        #{{ $comment->post->id }} {{ $comment->post->name }}
                        <input type="hidden" name="post_id" value="{{ $comment->post->id }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="parent_id">{{ __('elfcms::default.answer_to') }}</label>
                    <div class="input-wrapper">
                        <select name="parent_id" id="parent_id">
                            <option value="null"> - </option>
                        @foreach ($comments as $post)
                            <option value="{{ $post->id }}" @if ($post->active != 1) class="inactive" @endif @if ($post->id == $comment->parent_id) selected @endif>#{{ $post->id }} ({{ Str::limit($post->text, 15) }})@if ($post->active != 1) [{{ __('elfcms::default.inactive') }}] @endif</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="user_id">{{ __('elfcms::default.user') }}</label>
                    <div class="input-wrapper">
                        #{{ $comment->user->id }} {{ $comment->user->email }}
                        {{--<input type="text" name="user_id" id="user_id" autocomplete="off">--}}
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="text">{{ __('elfcms::default.text') }}</label>
                    <div class="input-wrapper">
                        <textarea name="text" id="text" cols="30" rows="10">{{ $comment->text }}</textarea>
                    </div>
                </div>
            </div>
            <div class="button-box single-box">
                <button type="submit" class="default-btn submit-button">{{ __('elfcms::default.submit') }}</button>
            </div>
        </form>
    </div>

@endsection
