@extends('elfcms::admin.layouts.blog')

@section('blogpage-content')

    @if (Session::has('result'))
        <div class="alert alert-success">{{ Session::get('result') }}</div>
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
        <h3>{{ __('blog::default.create_blog') }}</h3>
        <form action="{{ route('admin.blog.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
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
                                {{ __('elfcms::default.active') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="name">{{ __('elfcms::default.name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" autocomplete="off">
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="slug">{{ __('elfcms::default.slug') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="slug" id="slug" autocomplete="off">
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
                        <textarea name="description" id="description" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="preview">{{ __('elfcms::default.preview') }}</label>
                    <div class="input-wrapper">
                        <input type="hidden" name="preview_path" id="preview_path">
                        <div class="image-button">
                            <div class="delete-image hidden">&#215;</div>
                            <div class="image-button-img">
                                <img src="{{ asset('/vendor/elfcms/blog/admin/images/icons/upload.png') }}" alt="Upload file">
                            </div>
                            <div class="image-button-text">
                                {{ __('elfcms::default.choose_file') }}
                            </div>
                            <input type="file" name="preview" id="preview">
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="image">{{ __('elfcms::default.image') }}</label>
                    <div class="input-wrapper">
                        <input type="hidden" name="image_path" id="image_path">
                        <div class="image-button">
                            <div class="delete-image hidden">&#215;</div>
                            <div class="image-button-img">
                                <img src="{{ asset('/vendor/elfcms/blog/admin/images/icons/upload.png') }}" alt="Upload file">
                            </div>
                            <div class="image-button-text">
                                {{ __('elfcms::default.choose_file') }}
                            </div>
                            <input type="file" name="image" id="image">
                        </div>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="meta_keywords">{{ __('elfcms::default.meta_keywords') }}</label>
                    <div class="input-wrapper">
                        <textarea name="meta_keywords" id="meta_keywords" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <div class="input-box colored">
                    <label for="meta_description">{{ __('elfcms::default.meta_description') }}</label>
                    <div class="input-wrapper">
                        <textarea name="meta_description" id="meta_description" cols="30" rows="3"></textarea>
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
    </script>

@endsection
