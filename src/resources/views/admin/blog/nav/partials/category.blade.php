{{-- <div class="blog-nav-category">
    <a href="{{ route('admin.blog.categories.edit',$cat) }}">{{ $cat->name }}</a>
</div> --}}
<details class="blog-nav-category">
    <summary>
        <a href="{{ route('admin.blog.nav',['blog'=>$blog,'category'=>$cat]) }}">{{$cat->name}}</a>
        <div class="blog-nav-buttons">
            <a href="{{ route('admin.blog.posts.create',['category_id'=>$cat->id]) }}" class="blog-nav-button add-post" title="{{ __('blog::default.add_post') }}"></a>
            <a href="{{ route('admin.blog.categories.create',['category_id'=>$cat->id]) }}" class="blog-nav-button add-category" title="{{ __('blog::default.create_category') }}"></a>
            <a href="{{ route('admin.blog.categories.edit',$cat) }}" class="blog-nav-button edit" title="{{ __('blog::default.edit_category') }}"></a>
            <form action="{{ route('admin.blog.categories.destroy',$cat) }}" method="POST" data-submit="check" data-header="{{ __('blog::default.deleting_of_category',['category'=>$cat->name]) }}" data-message="{{ __('blog::default.are_you_sure_to_deleting_category') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $cat->id }}">
                <input type="hidden" name="name" value="{{ $cat->name }}">
                <button type="submit" class="blog-nav-button delete" title="{{ __('elfcms::default.delete') }}"></button>
            </form>
            <div class="contextmenu-content-box">
                <a href="{{ route('admin.blog.posts.create',['category_id'=>$cat->id]) }}" class="contextmenu-post" title="{{ __('blog::default.add_post') }}"></a>
                <a href="{{ route('admin.blog.categories.create',['category_id'=>$cat->id]) }}" class="contextmenu-post" title="{{ __('blog::default.create_category') }}"></a>
                <a href="{{ route('admin.blog.categories.edit',$cat) }}" class="contextmenu-post" title="{{ __('blog::default.edit_category') }}"></a>
                <form action="{{ route('admin.blog.categories.destroy',$cat) }}" method="POST" data-submit="check" data-header="{{ __('blog::default.deleting_of_category',['category'=>$cat->name]) }}" data-message="{{ __('blog::default.are_you_sure_to_deleting_category') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{ $cat->id }}">
                    <input type="hidden" name="name" value="{{ $cat->name }}">
                    <button type="submit" class="contextmenu-post" title="{{ __('elfcms::default.delete') }}"></button>
                </form>
            </div>
        </div>
    </summary>
@if ($cat->categories)
    @foreach ($cat->categories as $cat)
        @include('elfcms::admin.blog.nav.partials.category',['posts'=>$cat->posts])
    @endforeach
@endif
@if ($posts)
    @foreach ($posts as $post)
        @include('elfcms::admin.blog.nav.partials.post')
    @endforeach
@endif
</details>
