@extends('elfcms::admin.layouts.main')

@section('pagecontent')
    <div class="table-search-box">
        <a href="{{ route('admin.blog.comments') }}" class="button round-button theme-button" style="color:var(--);">
            {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/arrow_back.svg', svg: true) !!}
            <span class="button-collapsed-text">
                {{ __('elfcms::default.back') }}
            </span>
        </a>
    </div>

    <div class="item-form">
        <h2>{{ __('blog::default.edit_comment') }}</h2>
        <form action="{{ route('admin.blog.comments.update',$comment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="active">
                        {{ __('elfcms::default.active') }}
                    </label>
                    <x-elfcms::ui.checkbox.switch name="active" id="active" :checked="$comment->active" />
                </div>
                <div class="input-box colored">
                    <label for="post_id">{{ __('elfcms::default.post') }}</label>
                    <div class="input-wrapper">
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
                <button type="submit" class="button color-text-button success-button">{{ __('elfcms::default.submit') }}</button>
                <button type="submit" name="submit" value="save_and_close"
                    class="button color-text-button info-button">{{ __('elfcms::default.save_and_close') }}</button>
                <a href="{{ route('admin.blog.comments') }}" class="button color-text-button">{{ __('elfcms::default.cancel') }}</a>
            </div>
        </form>
    </div>

@endsection
