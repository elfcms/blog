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
        <h2>{{ __('elfcms::default.edit_post') }} #{{ $post->id }}</h2>
        <form action="{{ route('admin.blog.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                <input type="hidden" name="id" id="id" value="{{ $post->id }}">
                <div class="input-box colored">
                    <label for="active">
                        {{ __('elfcms::default.active') }}
                    </label>
                    <x-elfcms::ui.checkbox.switch name="active" id="active" checked="{{ $post->active }}" />
                </div>
                <div class="input-box colored">
                    <label for="blog_id">{{ __('blog::default.blog') }}</label>
                    <div class="input-wrapper">
                        <div class="input-wrapper">
                            #{{ $post->blog->id ?? '' }} {{ $post->blog->name ?? '' }}
                            <input type="hidden" name="blog_id" value="{{ $post->blog->id ?? null }}">
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="categories">{{ __('elfcms::default.categories') }}</label>
                    <div class="input-wrapper">
                        <select name="categories[]" id="categories" data-cond="blog">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @class([
                                    'inactive' => $category->active != 1,
                                    'hidden' => $category->blog_id != $category->blog_id,
                                ])
                                    data-blog="{{ $category->blog_id }}" @if (in_array($category->id, $postCategories)) selected @endif>
                                    {{ $category->name }}@if ($category->active != 1)
                                        [{{ __('elfcms::default.inactive') }}]
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- <div class="input-box colored">
                    <label for="category_id">{{ __('elfcms::default.category') }}</label>
                    <div class="input-wrapper">
                        <select name="category_id" id="category_id" data-cond="blog">
                            <option value="a">{{ __('elfcms::default.none') }}</option>
                        @foreach ($categories as $post)
                            <option value="{{ $post->id }}" @class(['inactive' => $post->active != 1, 'hidden' => $post->blog_id != $post->blog_id]) data-blog="{{ $post->blog_id }}" @if ($post->id == $post->category_id) selected @endif>{{ $post->name }}@if ($post->active != 1) [{{ __('elfcms::default.inactive') }}] @endif</option>
                        @endforeach
                        </select>
                    </div>
                </div> --}}
                <div class="input-box colored">
                    <label for="name">{{ __('elfcms::default.name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" autocomplete="off" value="{{ $post->name }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="slug">{{ __('elfcms::default.slug') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="slug" id="slug" autocomplete="off" value="{{ $post->slug }}">
                    </div>
                    <div class="input-wrapper">
                        <x-elfcms::ui.checkbox.autoslug textid="name" slugid="slug" checked="true" />
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="desctiption">{{ __('elfcms::default.description') }}</label>
                    <div class="input-wrapper">
                        <textarea name="description" id="description" cols="30" rows="10">{{ $post->description }}</textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="text">{{ __('elfcms::default.text') }}</label>
                    <div class="input-wrapper">
                        <textarea name="text" id="text" cols="30" rows="10">{{ $post->text }}</textarea>
                    </div>
                </div>

                <div class="input-box colored">
                    <label for="preview">{{ __('elfcms::default.preview') }}</label>
                    <div class="input-wrapper">
                        <x-elf-input-file value="{{ $post->preview }}" :params="['name' => 'preview']" :download="true" />
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="image">{{ __('elfcms::default.image') }}</label>
                    <div class="input-wrapper">
                        <x-elf-input-file value="{{ $post->image }}" :params="['name' => 'image']" :download="true" />
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="public_time">{{ __('elfcms::default.public_time') }}</label>
                    <div class="input-wrapper">
                        <input type="date" name="public_time[]" id="public_time" autocomplete="off"
                            value="{{ $post->public_time }}">
                        <input type="time" name="public_time[]" id="public_time_time" autocomplete="off"
                            value="{{ $post->public_time_time }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="end_time">{{ __('elfcms::default.end_time') }}</label>
                    <div class="input-wrapper">
                        <input type="date" name="end_time[]" id="end_time" autocomplete="off"
                            value="{{ $post->end_time }}">
                        <input type="time" name="end_time[]" id="end_time_time" autocomplete="off"
                            value="{{ $post->end_time_time }}">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="tags">{{ __('elfcms::default.tags') }}</label>
                    <div class="input-wrapper">
                        <div class="tag-form-wrapper">
                            <div class="tag-list-box">
                                @foreach ($post->tags as $tag)
                                    <div class="tag-item-box" data-id="{{ $tag->id }}">
                                        <span class="tag-post-name">{{ $tag->name }}</span>
                                        <span class="tag-post-remove" onclick="removeTagFromList(this)">&#215;</span>
                                        <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="tag-input-box">
                                <input type="text" class="tag-input" autocomplete="off">
                                <button type="button" class="button simple-button tag-add-button">Add</button>
                                <div class="tag-prompt-list"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="meta_keywords">{{ __('elfcms::default.meta_keywords') }}</label>
                    <div class="input-wrapper">
                        <textarea name="meta_keywords" id="meta_keywords" cols="30" rows="3">{{ $post->meta_keywords }}</textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="meta_description">{{ __('elfcms::default.meta_description') }}</label>
                    <div class="input-wrapper">
                        <textarea name="meta_description" id="meta_description" cols="30" rows="3">{{ $post->meta_description }}</textarea>
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
