@extends('elfcms::admin.layouts.main')

@section('pagecontent')
    <div class="table-search-box">
        <a href="{{ route('admin.blog.votes') }}" class="button round-button theme-button" style="color:var(--default-color);">
            {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/arrow_back.svg', svg: true) !!}
            <span class="button-collapsed-text">
                {{ __('elfcms::default.back') }}
            </span>
        </a>
    </div>

    <div class="item-form">
        <h2>{{ __('blog::default.create_like') }}</h2>
        <form action="{{ route('admin.blog.likes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="colored-rows-box">
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
                    <label for="value">{{ __('elfcms::default.value') }}</label>
                    <div class="input-wrapper">
                        <input type="number" name="value" id="value" autocomplete="off" max="1" min="-1">
                    </div>
                </div>
            </div>
            <div class="button-box single-box">
                <button type="submit" class="button color-text-button success-button">{{ __('elfcms::default.save') }}</button>
            </div>
        </form>
    </div>

@endsection
