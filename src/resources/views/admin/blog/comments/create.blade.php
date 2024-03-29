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
        <h3>{{ __('elfcms::default.create_post') }}</h3>
        <form action="{{ route('admin.blog.comments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <div class="checkbox-wrapper">
                        <div class="checkbox-inner">
                            <input
                                type="checkbox"
                                name="active"
                                id="active"
                                checked
                            >
                            <i></i>
                            <label for="active">
                                {{ __('elfcms::default.active') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="post_id">{{ __('elfcms::default.post') }}</label>
                    <div class="input-wrapper">
                        <select name="post_id" id="post_id">
                        @foreach ($posts as $post)
                            <option value="{{ $post->id }}" @if ($post->active != 1) class="inactive" @endif @if ($post->id == $post_id) selected @endif>{{ $post->name }}@if ($post->active != 1) [{{ __('elfcms::default.inactive') }}] @endif</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="parent_id">{{ __('elfcms::default.answer_to') }}</label>
                    <div class="input-wrapper">
                        <select name="parent_id" id="parent_id">
                            <option value="null"> - </option>
                        @foreach ($comments as $post)
                            <option value="{{ $post->id }}" @if ($post->active != 1) class="inactive" @endif @if ($post->id == $parent_id) selected @endif>#{{ $post->id }} ({{ Str::limit($post->text, 15) }})@if ($post->active != 1) [{{ __('elfcms::default.inactive') }}] @endif</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                {{--<div class="input-box colored">
                    <label for="user_id">{{ __('elfcms::default.user') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="user_id" id="user_id" autocomplete="off">
                    </div>
                </div>--}}
                <div class="input-box colored">
                    <label for="text">{{ __('elfcms::default.text') }}</label>
                    <div class="input-wrapper">
                        <textarea name="text" id="text" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <div class="button-box single-box">
                <button type="submit" class="default-btn submit-button">{{ __('elfcms::default.submit') }}</button>
            </div>
        </form>
    </div>

@endsection
