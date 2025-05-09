@forelse ($blogs as $ib)
<details  @class(['blog-nav-ib','selected' => $ib->id == $blog->id]) @if($ib->id == $blog->id) open @endif>
    <summary>
        <a href="{{ route('admin.blog.nav',['blog'=>$ib]) }}">{{ $ib->name }}</a>
        <a href="{{ route('admin.blog.blogs.edit',$ib) }}" class="button icon-button">
            {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/edit.svg', svg: true) !!}
        </a>
    </summary>
    {{-- @each('elfcms::admin.blog.nav.partials.detail',$ib->topCategories,'cat') --}}
    {{-- @if ($ib->topCategories) --}}
        {{-- @foreach ($ib->topCategories as $cat) --}}
        @forelse ($ib->topCategories as $cat)
            @include('elfcms::admin.blog.nav.partials.detail',['open' => $ib == $blog ? 'open' : ''])
        {{-- @endforeach --}}
        @empty
            {{-- <div class="blog-nav-list-none">{{ __('blog::default.no_categories') }}</div> --}}
            <div class="blog-nav-nothing">{{ __('blog::default.no_categories') }}</div>
        @endforelse

    {{-- @endif --}}
</details>
@empty
    {{-- <div class="blog-nav-list-none">{{ __('elfcms::default.nothing_was_found') }}</div> --}}
    <div class="blog-nav-nothing">{{ __('elfcms::default.nothing_was_found') }}</div>
@endforelse
