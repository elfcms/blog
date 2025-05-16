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
        <h3>{{ __('blog::default.edit_like') }}</h3>
        <form action="{{ route('admin.blog.likes.update',$like->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="post_id">{{ __('elfcms::default.post') }}</label>
                    <div class="input-wrapper">
                        #{{ $like->post->id }} {{ $like->post->name }}
                        <input type="hidden" name="blog_posts_id" value="{{ $like->post->id }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="user_id">{{ __('elfcms::default.user') }}</label>
                    <div class="input-wrapper">
                        #{{ $like->user->id }} {{ $like->user->email }}
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="value">{{ __('elfcms::default.value') }}</label>
                    <div class="input-wrapper">
                        <input type="number" name="value" id="value" autocomplete="off" max="1" min="-1" value="{{ $like->value }}">
                    </div>
                </div>
            </div>
            <div class="button-box single-box">
                <button type="submit" class="button color-text-button success-button">{{ __('elfcms::default.save') }}</button>
            </div>
        </form>
    </div>

@endsection
