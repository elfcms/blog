<div class="blog-nav-topbuttons">
    @if (!empty($blog->id))
    <a href="{{ route('admin.blog.categories.create',['blog'=>$blog,'category_id'=>$category->id??null]) }}" class="default-btn success-button icon-text-button light-icon plus-button">
        {{ __('blog::default.add_category') }}
    </a>
    <a href="{{ route('admin.blog.posts.create',['blog'=>$blog,'category_id'=>$category->id ?? null]) }}" class="default-btn success-button icon-text-button light-icon plus-button">
        {{ __('blog::default.add_post') }}
    </a>
    @endif
</div>
