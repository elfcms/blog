@extends('basic::admin.layouts.basic')

@section('pagecontent')

<div class="big-container">

    <nav class="pagenav">
        <ul>
            <li>
                <a href="{{ route('admin.blog.blogs') }}" class="button button-left">{{ __('blog::elf.blogs') }}</a>
                <a href="{{ route('admin.blog.blogs.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.categories') }}" class="button button-left">{{ __('blog::elf.categories') }}</a>
                <a href="{{ route('admin.blog.categories.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.posts') }}" class="button button-left">{{ __('blog::elf.posts') }}</a>
                <a href="{{ route('admin.blog.posts.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.tags') }}" class="button button-left">{{ __('blog::elf.tags') }}</a>
                <a href="{{ route('admin.blog.tags.create') }}" class="button button-right">+</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.comments') }}" class="button">{{ __('blog::elf.comments') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.votes') }}" class="button">{{ __('blog::elf.votes') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.blog.likes') }}" class="button">{{ __('blog::elf.likes') }}</a>
            </li>
        </ul>
    </nav>
    @section('blogpage-content')
    @show

</div>
@endsection
