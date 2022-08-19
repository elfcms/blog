@extends('basic::admin.layouts.blog')

@section('blogpage-content')

    @if (Session::has('likeedited'))
        <div class="alert alert-success">{{ Session::get('likeedited') }}</div>
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

    <div class="item-form">
        <h3>{{ __('basic::elf.create_post') }}</h3>
        <form action="{{ route('admin.blog.likes.update',$like->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                                {{ __('basic::elf.active') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="post_id">{{ __('basic::elf.post') }}</label>
                    <div class="input-wrapper">
                        <select name="post_id" id="post_id">
                        @foreach ($posts as $post)
                            <option value="{{ $post->id }}" @if ($post->active != 1) class="inactive" @endif @if ($post->id == $like->post_id) selected @endif>{{ $post->name }}@if ($post->active != 1) [{{ __('basic::elf.inactive') }}] @endif</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="user_id">{{ __('basic::elf.user') }}</label>
                    <div class="input-wrapper">
                        #{{ $like->user->id }} {{ $like->user->email }}
                        {{--<input type="text" name="user_id" id="user_id" autocomplete="off">--}}
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="value">{{ __('basic::elf.value') }}</label>
                    <div class="input-wrapper">
                        <input type="number" name="value" id="value" autocomplete="off" max="1" min="-1" value="{{ $like->value }}">
                    </div>
                </div>
            </div>
            <div class="button-box single-box">
                <button type="submit" class="default-btn submit-button">{{ __('basic::elf.submit') }}</button>
            </div>
        </form>
    </div>

@endsection
