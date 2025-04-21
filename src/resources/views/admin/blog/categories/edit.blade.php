@extends('elfcms::admin.layouts.main')

@section('pagecontent')
    <div class="table-search-box">
        <a href="{{ route('admin.blog.nav',$navParams) }}" class="button round-button theme-button" style="color:var(--);">
            {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/arrow_back.svg', svg: true) !!}
            <span class="button-collapsed-text">
                {{ __('elfcms::default.back') }}
            </span>
        </a>
    </div>

    <div class="item-form">
        <h2>{{ __('elfcms::default.edit_category') }}{{ $category->id }}</h2>
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
                    <label for="active">
                        {{ __('elfcms::default.active') }}
                    </label>
                    <x-elfcms::ui.checkbox.switch name="active" id="active" :checked="$category->active" />
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
                        <x-elfcms::ui.checkbox.autoslug textid="name" slugid="slug" checked="true" />
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
                        <x-elf-input-file value="{{ $category->preview }}" :params="['name' => 'preview']" :download="true" />
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="image">{{ __('elfcms::default.image') }}</label>
                    <div class="input-wrapper">
                        <x-elf-input-file value="{{ $category->image }}" :params="['name' => 'image']" :download="true" />
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
                <button type="submit" class="button color-text-button success-button">{{ __('elfcms::default.submit') }}</button>
                <button type="submit" name="submit" value="save_and_close"
                    class="button color-text-button info-button">{{ __('elfcms::default.save_and_close') }}</button>
                <a href="{{ route('admin.blog.nav',$navParams) }}" class="button color-text-button">{{ __('elfcms::default.cancel') }}</a>
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
