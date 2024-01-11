@extends('elfcms::admin.layouts.blognav')

@section('navpage-content')
<div class="blog-nav-box">
    <div class="blog-nav-left">
        <div class="invobox-nav-leftbutton">
            <a href="{{ route('admin.blog.blogs.create') }}" class="default-btn success-button icon-text-button light-icon plus-button">
                {{ __('blog::default.create_blog') }}
            </a>
        </div>
    </div>
    <div class="blog-nav-right">
        <div class="blog-nav-content">
            @include('elfcms::admin.blog.nav.partials.buttons')
        </div>
    </div>
</div>
<div class="blog-nav-box">
    <div class="blog-nav-left">
        @include('elfcms::admin.blog.nav.list')
    </div>
    <div class="blog-nav-right" id="blog_nav_content">
        @include('elfcms::admin.blog.nav.content')
    </div>
</div>
@if (!empty($message))
    @include('elfcms::admin.blog.nav.partials.message')
@endif
@endsection
