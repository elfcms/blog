<div class="blog-nav-cat blog-nav-line" data-id="{{ $cat->id }}" data-line="category">
    <div class="blog-line-position" data-line="category" draggable="true">
        {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/drag_indicator_slim.svg', svg: true) !!}
        <span>{{ $cat->position ?? 0 }}</span>
    </div>
    <a class="blog-line-title" href="{{ route('admin.blog.nav',['blog'=>$blog,'category'=>$cat]) }}">{{ $cat->name }}</a>
    <a href="{{ route('admin.blog.categories.edit',$cat) }}" class="button icon-button">
        {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/edit.svg', svg: true) !!}
    </a>
    <form action="{{ route('admin.blog.blogs.destroy',$cat) }}" method="POST" data-submit="check" data-header="{{ __('blog::default.deleting_of_element',['blog'=>$cat->name]) }}" data-message="{{ __('blog::default.are_you_sure_to_deleting_element') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" value="{{ $cat->id }}">
        <input type="hidden" name="name" value="{{ $cat->name }}">
        <button type="submit" class="button icon-button icon-alarm-button" title="{{ __('elfcms::default.delete') }}" >
            {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/delete.svg', svg: true) !!}
        </button>
    </form>
</div>
