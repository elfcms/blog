@extends('elfcms::admin.layouts.blog')

@section('blogpage-content')

    @if (Session::has('voteedited'))
        <div class="alert alert-success">{{ Session::get('voteedited') }}</div>
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
        <form action="{{ route('admin.blog.votes.update',$vote->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                {{-- <div class="input-box colored">
                    <x-elfcms-input-checkbox code="active" label="{{ __('elfcms::default.active') }}" style="blue" :checked="$vote->active" />
                </div> --}}
                <div class="input-box colored">
                    <label for="post_id">{{ __('elfcms::default.post') }}</label>
                    <div class="input-wrapper">
                        {{-- <select name="post_id" id="post_id">
                        @foreach ($posts as $post)
                            <option value="{{ $post->id }}" @if ($post->active != 1) class="inactive" @endif @if ($post->id == $vote->post_id) selected @endif>{{ $post->name }}@if ($post->active != 1) [{{ __('elfcms::default.inactive') }}] @endif</option>
                        @endforeach
                        </select> --}}
                        #{{ $vote->post->id }} {{ $vote->post->name }}
                        <input type="hidden" name="post_id" value="{{ $vote->post->id }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="user_id">{{ __('elfcms::default.user') }}</label>
                    <div class="input-wrapper">
                        #{{ $vote->user->id }} {{ $vote->user->email }}
                        {{--<input type="text" name="user_id" id="user_id" autocomplete="off">--}}
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
                <button type="submit" class="default-btn submit-button">{{ __('elfcms::default.submit') }}</button>
            </div>
        </form>
    </div>

@endsection
