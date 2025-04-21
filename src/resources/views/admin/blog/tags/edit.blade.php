@extends('elfcms::admin.layouts.blog')

@section('pagecontent')
    <div class="table-search-box">
        <a href="{{ route('admin.blog.tags') }}" class="button round-button theme-button" style="color:var(--);">
            {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/arrow_back.svg', svg: true) !!}
            <span class="button-collapsed-text">
                {{ __('elfcms::default.back') }}
            </span>
        </a>
    </div>

    <div class="item-form">
        <h2>{{ __('elfcms::default.edit_tag') }} #{{ $tag->id }}</h2>
        <form action="{{ route('admin.blog.tags.update', $tag->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="colored-rows-box">
                <div class="input-box colored">
                    <label for="name">{{ __('elfcms::default.name') }}</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" autocomplete="off" value="{{ $tag->name }}">
                    </div>
                </div>
            </div>
            <div class="button-box single-box">
                <button type="submit"
                    class="button color-text-button success-button">{{ __('elfcms::default.submit') }}</button>
            </div>
        </form>
    </div>
    <script>
        tagInput('#name')
    </script>
@endsection
