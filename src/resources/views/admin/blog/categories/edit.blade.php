@extends('elfcms::admin.layouts.blog')

@section('blogpage-content')

    @if (Session::has('categoryedited'))
        <div class="alert alert-success">{{ Session::get('categoryedited') }}</div>
    @endif
    @if (Session::has('categorycreated  '))
        <div class="alert alert-success">{{ Session::get('categorycreated') }}</div>
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
        <h3>{{ __('elfcms::default.edit_category') }}{{ $category->id }}</h3>
        <div class="date-info create-info">
            {{ __('elfcms::default.created_at') }}: {{ $category->created }}
        </div>
        <div class="date-info update-info">
            {{ __('elfcms::default.updated_at') }}: {{ $category->updated }}
        </div>
        <form action="{{ route('admin.blog.categories.update',$category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                <input type="hidden" name="id" id="id" value="{{ $category->id }}">
                <div class="input-box colored">
                    <x-elfcms-input-checkbox code="active" label="{{ __('elfcms::default.active') }}" style="blue" :checked="$category->active" />
                </div>
                <div class="input-box colored">
                    <label for="blog_id">{{ __('blog::default.blog') }}</label>
                    <div class="input-wrapper">
                        <div class="input-wrapper">
                            #{{ $category->blog->id }} {{ $category->blog->name }}
                            <input type="hidden" name="blog_id" value="{{ $category->blog->id }}">
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="parent_id">{{ __('elfcms::default.parent') }}</label>
                    <div class="input-wrapper">
                        <select name="parent_id" id="parent_id" data-cond="blog">
                            <option value="">{{ __('elfcms::default.none') }}</option>
                        @foreach ($categories as $post)
                            @if ($post->id != $category->id)
                                <option value="{{ $post->id }}" @class(['inactive' => $post->active != 1, 'hidden' => $post->blog_id != $category->blog_id]) data-blog="{{ $post->blog_id }}" @if ($post->id == $category->parent_id) selected @endif>{{ $post->name }}@if ($post->active != 1) [{{ __('elfcms::default.inactive') }}] @endif</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="name">{{ __('elfcms::default.name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" autocomplete="off" value="{{ $category->name }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="slug">{{ __('elfcms::default.slug') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="slug" id="slug" autocomplete="off" value="{{ $category->slug }}">
                    </div>
                    <div class="input-wrapper">
                        <div class="autoslug-wrapper">
                            <input type="checkbox" data-text-id="name" data-slug-id="slug" class="autoslug" checked>
                            <div class="autoslug-button"></div>
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="desctiption">{{ __('elfcms::default.description') }}</label>
                    <div class="input-wrapper">
                        <textarea name="description" id="description" cols="30" rows="10">{{ $category->description }}</textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="preview">{{ __('elfcms::default.preview') }}</label>
                    <div class="input-wrapper">
                        <x-elfcms-input-image code="preview" value="{{$category->preview}}" />
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="image">{{ __('elfcms::default.image') }}</label>
                    <div class="input-wrapper">
                        <x-elfcms-input-image code="image" value="{{$category->image}}" />
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="public_time">{{ __('elfcms::default.public_time') }}</label>
                    <div class="input-wrapper">
                        <input type="date" name="public_time[]" id="public_time" autocomplete="off" value="{{ $category->public_time }}">
                        <input type="time" name="public_time[]" id="public_time_time" autocomplete="off" value="{{ $category->public_time_time }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="end_time">{{ __('elfcms::default.end_time') }}</label>
                    <div class="input-wrapper">
                        <input type="date" name="end_time[]" id="end_time" autocomplete="off" value="{{ $category->end_time }}">
                        <input type="time" name="end_time[]" id="end_time_time" autocomplete="off" value="{{ $category->end_time_time }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="meta_keywords">{{ __('elfcms::default.meta_keywords') }}</label>
                    <div class="input-wrapper">
                        <textarea name="meta_keywords" id="meta_keywords" cols="30" rows="3">{{ $category->meta_keywords }}</textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="meta_description">{{ __('elfcms::default.meta_description') }}</label>
                    <div class="input-wrapper">
                        <textarea name="meta_description" id="meta_description" cols="30" rows="3">{{ $category->meta_description }}</textarea>
                    </div>
                </div>
            </div>
            <div class="button-box single-box">
                <button type="submit" class="default-btn submit-button">{{ __('elfcms::default.submit') }}</button>
            </div>
        </form>
    </div>
    <script>
    const imageInput = document.querySelector('#image')
    if (imageInput) {
        inputFileImg(imageInput)
    }
    const previewInput = document.querySelector('#preview')
    if (previewInput) {
        inputFileImg(previewInput)
    }

    autoSlug('.autoslug')
    //add editor
    runEditor('#description')
    selectCondition('blog');
    </script>

@endsection
