{{-- <div class="blog-nav-up-ib">
    <a href="{{ route('admin.blog.nav',['blog'=>$blog]) }}">{{ $blog->name }}</a>
</div>
@if ($category)
<div class="blog-nav-up-cat">
    <a href="{{ route('admin.blog.nav',['blog'=>$blog,'category'=>$category]) }}">{{ $category->name }}</a>
</div>
@endif --}}
@if ($category || $blog->name)
<h4 class="blog-nav-title">
    {{ $category->name ?? $blog->name ?? __('blog::default.blogs') }}
</h4>
<div class="blog-nav-content">
    @if ($category)
        @if ($category->parent)
            <a class="blog-nav-up" href="{{ route('admin.blog.nav',['blog'=>$blog,'category'=>$category->parent]) }}">..</a>
        @else
            <a class="blog-nav-up" href="{{ route('admin.blog.nav',['blog'=>$blog]) }}">..</a>
        @endif
        @if ($category->categories)
        <div class="blog-nav-categories blog-nav-dnd-area blog-nav-dnd-area-cat" data-container="category">
            @foreach ($category->categories as $cat)
                @include('elfcms::admin.blog.nav.partials.category-line',['posts'=>$cat->posts])
            @endforeach
        </div>
        @endif
        @if ($category->posts)
        <div class="blog-nav-posts blog-nav-dnd-area blog-nav-dnd-area-post" data-container="post">
            @foreach ($category->posts()->position()->get() as $post)
                @include('elfcms::admin.blog.nav.partials.post-line')
            @endforeach
        </div>
        @endif
    @else
        @if (!empty($blog->topCategories))
        <div class="blog-nav-categories blog-nav-dnd-area blog-nav-dnd-area-cat" data-container="category">
            @foreach ($blog->topCategories as $cat)
                @include('elfcms::admin.blog.nav.partials.category-line',['posts'=>$cat->posts])
            @endforeach
        </div>
        @endif
        @if (!empty($blog->posts))
        <div class="blog-nav-posts blog-nav-dnd-area blog-nav-dnd-area-post" data-container="post">
            @foreach ($blog->topPosts()->position()->get() as $post)
                @include('elfcms::admin.blog.nav.partials.post-line')
            @endforeach
        </div>
        @endif
    @endif
</div>
@else
<div class="blog-nav-content">
    <div class="blog-nav-dnd-area blog-nav-dnd-area-ib">
    @forelse ($blogs as $ib)
        @include('elfcms::admin.blog.nav.partials.blog')
    @empty
        <div class="blog-nav-list-none">{{ __('elfcms::default.nothing_was_found') }}</div>
    @endforelse
    </div>
</div>
@endif
<script>
const checkForms = document.querySelectorAll('form[data-submit="check"]')
function setConfirmDelete(forms) {
    if (forms) {
        forms.forEach(form => {
            form.addEventListener('submit',function(e){
                e.preventDefault();
                let categoryId = this.querySelector('[name="id"]').value,
                    categoryName = this.querySelector('[name="name"]').value,
                    header = this.dataset.header,
                    message = this.dataset.message,
                    self = this
                popup({
                    title: header,
                    content:'<p>' + message + '</p>',
                    buttons:[
                        {
                            title:'{{ __('elfcms::default.delete') }}',
                            class:'default-btn delete-button',
                            callback: function(){
                                self.submit()
                            }
                        },
                        {
                            title:'{{ __('elfcms::default.cancel') }}',
                            class:'default-btn cancel-button',
                            callback:'close'
                        }
                    ],
                    class:'danger'
                })
            })
        })
    }
}

setConfirmDelete(checkForms)
/*
const rows = document.querySelectorAll('.blog-nav-category summary, .blog-nav-post');
if (rows) {
    rows.forEach(row => {
        row.addEventListener('contextmenu',function(e){
            const box = row.querySelector('.contextmenu-content-box')
            if (box) {
                e.preventDefault()
                let content = box.cloneNode(true)
                let forms  = content.querySelectorAll('form[data-submit="check"]')
                setConfirmDelete(forms)
                contextPopup(content,{'left':e.x,'top':e.y})
            }
        })
    })
}
window.onload = (event) => {
  console.log("page is fully loaded");
};*/
</script>
@section('footerscript')
<script src="{{ asset('elfcms/admin/modules/blog/js/navlineorder.js') }}"></script>
@endsection
