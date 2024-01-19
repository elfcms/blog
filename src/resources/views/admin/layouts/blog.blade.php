@extends('elfcms::admin.layouts.main')

@section('pagecontent')

<div class="big-container">

    {{-- <nav class="pagenav">
        <ul>
            <li>
                <a href="{{ route('admin.blog.blogs') }}" class="button button-left">{{ __('blog::default.blogs') }}</a>
                <a href="{{ route('admin.blog.blogs.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.categories') }}" class="button button-left">{{ __('blog::default.categories') }}</a>
                <a href="{{ route('admin.blog.categories.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.posts') }}" class="button button-left">{{ __('blog::default.posts') }}</a>
                <a href="{{ route('admin.blog.posts.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.tags') }}" class="button button-left">{{ __('blog::default.tags') }}</a>
                <a href="{{ route('admin.blog.tags.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.comments') }}" class="button">{{ __('blog::default.comments') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.votes') }}" class="button">{{ __('blog::default.votes') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.likes') }}" class="button">{{ __('blog::default.likes') }}</a>
            </li>
        </ul>
    </nav> --}}
    @section('blogpage-content')
    @show

</div>
@endsection
