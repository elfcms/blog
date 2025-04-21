@extends('elfcms::admin.layouts.main')

@section('pagecontent')
    <div class="table-search-box">
        <a href="{{ route('admin.blog.votes') }}" class="button round-button theme-button" style="color:var(--);">
            {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/arrow_back.svg', svg: true) !!}
            <span class="button-collapsed-text">
                {{ __('elfcms::default.back') }}
            </span>
        </a>
    </div>

    <div class="item-form">
        <h2>{{ __('blog::default.edit_vote') }}</h2>
        <form action="{{ route('admin.blog.votes.update',$vote->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="post_id">{{ __('elfcms::default.post') }}</label>
                    <div class="input-wrapper">
                        #{{ $vote->post->id }} {{ $vote->post->name }}
                        <input type="hidden" name="post_id" value="{{ $vote->post->id }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="user_id">{{ __('elfcms::default.user') }}</label>
                    <div class="input-wrapper">
                        #{{ $vote->user->id }} {{ $vote->user->email }}
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="value">{{ __('elfcms::default.value') }}</label>
                    <div class="input-wrapper">
                        <input type="number" name="value" id="value" autocomplete="off" max="100" min="1" value="{{ $vote->value }}">
                    </div>
                </div>
            </div>
            <div class="button-box single-box">
                <button type="submit" class="button color-text-button success-button">{{ __('elfcms::default.submit') }}</button>
            </div>
        </form>
    </div>

@endsection
