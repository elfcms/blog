<div class="blog-nav-el blog-nav-line" data-line="post" data-id="{{ $post->id }}">
    <div class="blog-line-position" data-line="post" draggable="true">{{ $post->position ?? 0 }}</div>
    <span class="blog-line-title" {{-- href="{{ route('admin.blog.nav',['post'=>$post]) }}" --}}>{{ $post->name }}</span>
    <a href="{{ route('admin.blog.posts.edit',$post) }}" class="inline-button circle-button alternate-button"></a>
    <form action="{{ route('admin.blog.blogs.destroy',$post) }}" method="POST" data-submit="check" data-header="{{ __('blog::default.deleting_of_element',['blog'=>$post->name]) }}" data-message="{{ __('blog::default.are_you_sure_to_deleting_element') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" value="{{ $post->id }}">
        <input type="hidden" name="name" value="{{ $post->name }}">
        <button type="submit" class="inline-button circle-button delete-button" title="{{ __('elfcms::default.delete') }}" ></button>
    </form>
</div>
