<div class="blog-nav-cat blog-nav-line" data-id="{{ $cat->id }}" data-line="category">
    <div class="blog-line-position" data-line="category" draggable="true">{{ $cat->position ?? 0 }}</div>
    <a class="blog-line-title" href="{{ route('admin.blog.nav',['blog'=>$blog,'category'=>$cat]) }}">{{ $cat->name }}</a>
    <a href="{{ route('admin.blog.categories.edit',$cat) }}" class="inline-button circle-button alternate-button"></a>
    <form action="{{ route('admin.blog.blogs.destroy',$cat) }}" method="POST" data-submit="check" data-header="{{ __('blog::default.deleting_of_element',['blog'=>$cat->name]) }}" data-message="{{ __('blog::default.are_you_sure_to_deleting_element') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" value="{{ $cat->id }}">
        <input type="hidden" name="name" value="{{ $cat->name }}">
        <button type="submit" class="inline-button circle-button delete-button" title="{{ __('elfcms::default.delete') }}" ></button>
    </form>
</div>
