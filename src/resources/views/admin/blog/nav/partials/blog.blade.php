<div class="blog-nav-blog blog-nav-line" data-id="{{ $ib->id }}">
    <div class="blog-line-position" data-line="blog" draggable="true">{{ $ib->position }}</div>
    <a class="blog-line-title" href="{{ route('admin.blog.nav',['blog'=>$ib]) }}">{{ $ib->title }}</a>
    <a href="{{ route('admin.blog.blogs.edit',$ib) }}" class="inline-button circle-button alternate-button"></a>
    <form action="{{ route('admin.blog.blogs.destroy',$ib) }}" method="POST" data-submit="check" data-header="{{ __('blog::default.deleting_of_blog',['blog'=>$ib->title]) }}" data-message="{{ __('blog::default.are_you_sure_to_deleting_blog') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" value="{{ $ib->id }}">
        <input type="hidden" name="name" value="{{ $ib->name }}">
        <button type="submit" class="inline-button circle-button delete-button" title="{{ __('elfcms::default.delete') }}" ></button>
    </form>
</div>
