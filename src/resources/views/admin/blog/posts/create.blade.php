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
        <h2>{{ __('elfcms::default.create_post') }}</h2>
        <form action="{{ route('admin.blog.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="active">
                        {{ __('elfcms::default.active') }}
                    </label>
                    <x-elfcms::ui.checkbox.switch name="active" id="active" checked="true" />
                </div>
                <div class="input-box colored">
                    <label for="blog_id">{{ __('blog::default.blog') }}</label>
                    <div class="input-wrapper">
                    @if (!empty($currentBlog))
                        #{{ $currentBlog->id }} {{ $currentBlog->name }}
                        <input type="hidden" name="blog_id" value="{{ $currentBlog->id }}">
                    @else
                        <select name="blog_id" id="blog_id">
                        @foreach ($blogs as $blog)
                            <option value="{{ $blog->id }}" data-id="{{ $blog->id }}">{{ $blog->name }}</option>
                        @endforeach
                        </select>
                    @endif
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="category_id">{{ __('elfcms::default.category') }}</label>
                    <div class="input-wrapper">
                        <select name="category_id" id="category_id" data-cond="blog">
                            <option value="">{{ __('elfcms::default.none') }}</option>
                        @foreach ($categories as $post)
                            <option value="{{ $post->id }}"  @class(['inactive' => $post->active != 1, 'hidden' => (!empty($blogs) && $post->blog_id != $blogs[0]->id)]) data-blog="{{ $post->blog_id }}" @if ($post->id == $category_id) selected @endif>{{ $post->name }}@if ($post->active != 1) [{{ __('elfcms::default.inactive') }}] @endif</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="name">{{ __('elfcms::default.name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" value="{{ $fields['name'] }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="slug">{{ __('elfcms::default.slug') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="slug" id="slug" value="{{ $fields['slug'] }}">
                    </div>
                    <div class="input-wrapper">
                        <x-elfcms::ui.checkbox.autoslug textid="name" slugid="slug" checked="true" />
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="desctiption">{{ __('elfcms::default.description') }}</label>
                    <div class="input-wrapper">
                        <textarea name="description" id="description" cols="30" rows="10">{{ $fields['description'] }}</textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="text">{{ __('elfcms::default.text') }}</label>
                    <div class="input-wrapper">
                        <textarea name="text" id="text" cols="30" rows="10">{{ $fields['text'] }}</textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="preview">{{ __('elfcms::default.preview') }}</label>
                    <div class="input-wrapper">
                        {{-- <x-elfcms-input-image code="preview" /> --}}
                        <x-elf-input-file value="" :params="['name' => 'preview']" :download="true" />
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="image">{{ __('elfcms::default.image') }}</label>
                    <div class="input-wrapper">
                        {{-- <x-elfcms-input-image code="image" /> --}}
                        <x-elf-input-file value="" :params="['name' => 'image']" :download="true" />
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="public_time">{{ __('elfcms::default.public_time') }}</label>
                    <div class="input-wrapper">
                        <input type="date" name="public_time[]" id="public_time" value="{{ $fields['public_time'][0] ?? null }}">
                        <input type="time" name="public_time[]" id="public_time_time" value="{{ $fields['public_time'][1] ?? null }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="end_time">{{ __('elfcms::default.end_time') }}</label>
                    <div class="input-wrapper">
                        <input type="date" name="end_time[]" id="end_time" value="{{ $fields['end_time'][0] ?? null }}">
                        <input type="time" name="end_time[]" id="end_time_time" value="{{ $fields['end_time'][1] ?? null }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="meta_keywords">{{ __('elfcms::default.meta_keywords') }}</label>
                    <div class="input-wrapper">
                        <textarea name="meta_keywords" id="meta_keywords" cols="30" rows="3" data-editor="quill">{{ $fields['meta_keywords'] }}</textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="meta_description">{{ __('elfcms::default.meta_description') }}</label>
                    <div class="input-wrapper">
                        <textarea name="meta_description" id="meta_description" cols="30" rows="3">{{ $fields['meta_description'] }}</textarea>
                    </div>
                </div>

                <div class="input-box colored">
                    <label for="tags">{{ __('elfcms::default.tags') }}</label>
                    <div class="input-wrapper">
                        <div class="tag-form-wrapper">
                            <div class="tag-list-box"></div>
                            <div class="tag-input-box">
                                <input type="text" class="tag-input">
                                <button type="button" class="button simple-button tag-add-button">Add</button>
                                <div class="tag-prompt-list"></div>
                            </div>
                        </div>
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

    tagFormInit()
    //add editor
    runEditor('#description')
    runEditor('#text')
    selectCondition('blog');
    </script>

@endsection
