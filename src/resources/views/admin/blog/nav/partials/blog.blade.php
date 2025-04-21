<div class="blog-nav-blog blog-nav-line" data-id="{{ $ib->id }}">
    <div class="blog-line-position" data-line="blog" {{-- draggable="true" --}}>{{-- {{ $ib->position ?? '&nbsp;' }} --}}
        {{-- {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/drag_indicator_slim.svg', svg: true) !!} --}}
        &nbsp;
    </div>
    <a class="blog-line-title" href="{{ route('admin.blog.nav',['blog'=>$ib]) }}">{{ $ib->name }}</a>
    <a href="{{ route('admin.blog.blogs.edit',$ib) }}" class="button icon-button">
        {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/edit.svg', svg: true) !!}
    </a>
    <form action="{{ route('admin.blog.blogs.destroy',$ib) }}" method="POST" data-submit="check" data-header="{{ __('blog::default.deleting_of_element',['blog'=>$ib->name]) }}" data-message="{{ __('blog::default.are_you_sure_to_deleting_blog') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" value="{{ $ib->id }}">
        <input type="hidden" name="name" value="{{ $ib->name }}">
        <button type="submit" class="button icon-button icon-alarm-button" title="{{ __('elfcms::default.delete') }}" >
            {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/delete.svg', svg: true) !!}
        </button>
    </form>
</div>
