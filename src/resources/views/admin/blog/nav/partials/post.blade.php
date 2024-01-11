<div class="blog-nav-post">
    <a href="{{ route('admin.blog.posts.edit',$post) }}">{{ $post->name }}</a>
    <div class="blog-nav-buttons">
        <a href="{{ route('admin.blog.posts.edit',$post) }}" class="blog-nav-button edit" title="{{ __('blog::default.edit_post') }}"></a>
        <form action="{{ route('admin.blog.posts.destroy',$post) }}" method="POST" data-submit="check" data-header="{{ __('blog::default.deleting_of_post',['post'=>$post->name]) }}" data-message="{{ __('blog::default.are_you_sure_to_deleting_post') }}">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" value="{{ $post->id }}">
            <input type="hidden" name="name" value="{{ $post->name }}">
            <button type="submit" class="blog-nav-button delete" title="{{ __('elfcms::default.delete') }}" ></button>
        </form>
        <div class="contextmenu-content-box">
            <a href="{{ route('admin.blog.posts.edit',$post) }}" class="contextmenu-post">{{ __('blog::default.edit_post') }}</a>
            <form action="{{ route('admin.blog.posts.destroy',$post) }}" method="POST" data-submit="check" data-header="{{ __('blog::default.deleting_of_post',['post'=>$post->name]) }}" data-message="{{ __('blog::default.are_you_sure_to_deleting_post') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $post->id }}">
                <input type="hidden" name="name" value="{{ $post->name }}">
                <button type="submit" class="contextmenu-post">{{ __('elfcms::default.delete') }}</button>
            </form>
        </div>
    </div>
</div>
