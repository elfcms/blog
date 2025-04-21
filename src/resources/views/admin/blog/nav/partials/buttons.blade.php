<div class="blog-nav-topbuttons">
    @if (!empty($blog->id))
    <a href="{{ route('admin.blog.categories.create',['blog'=>$blog,'category_id'=>$category->id??null]) }}" class="button round-button theme-button">
        {!! iconHtmlLocal('elfcms/admin/images/icons/plus.svg', svg: true) !!}
        <span>{{ __('blog::default.create_category') }}</span>
    </a>
    <a href="{{ route('admin.blog.posts.create',['blog'=>$blog,'category_id'=>$category->id ?? null]) }}" class="button round-button theme-button">
        {!! iconHtmlLocal('elfcms/admin/images/icons/plus.svg', svg: true) !!}
        <span>{{ __('blog::default.add_post') }}</span>
    </a>
    @endif
</div>
