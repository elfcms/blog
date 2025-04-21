@extends('elfcms::admin.layouts.main')

@section('pagecontent')
    <div class="blog-nav-container"
        @if (!empty($pageConfig['second_color'])) style="--second-color:{{ $pageConfig['second_color'] }};" @endif>
        <div class="blog-nav-box">
            <div class="blog-nav-left">
                <div class="invobox-nav-leftbutton">
                    <a href="{{ route('admin.blog.blogs.create') }}" class="button round-button theme-button">
                        {!! iconHtmlLocal('elfcms/admin/images/icons/plus.svg', svg: true) !!}
                        <span>{{ __('blog::default.create_blog') }}</span>
                    </a>
                </div>
            </div>
            <div class="blog-nav-right">
                <div class="blog-nav-content">
                    @include('elfcms::admin.blog.nav.partials.buttons')
                </div>
            </div>
        </div>
        <div class="blog-nav-box blog-nav-content-box">
            <div class="blog-nav-left glass">
                @include('elfcms::admin.blog.nav.list')
            </div>
            <div class="blog-nav-right glass" id="blog_nav_content">
                <div class="blog-nav-content">
                    @include('elfcms::admin.blog.nav.content')
                </div>
            </div>
        </div>
    </div>
    @if (!empty($message))
        @include('elfcms::admin.blog.nav.partials.message')
    @endif
@endsection
