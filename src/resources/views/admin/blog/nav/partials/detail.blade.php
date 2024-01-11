<details @class(['blog-nav-cat', 'empty'=>$cat->categories->count()==0, 'selected' => (!empty($category) && $cat->id == $category->id)]) @if((!empty($category) && $cat->id == $category->id) || (!empty($category) && in_array($cat->id, $category->parentsID()))) open @endif>
    <summary>
        <a href="{{ route('admin.blog.nav',['blog'=>$cat->blog,'category'=>$cat]) }}">{{$cat->name}}</a>
        <a href="{{ route('admin.blog.categories.edit',$cat) }}" class="inline-button circle-button alternate-button"></a>
    </summary>
@if ($cat->categories)
    {{-- @each('elfcms::admin.blog.nav.partials.detail',$cat->categories,'cat') --}}
    @foreach ($cat->categories as $cat)
        @include('elfcms::admin.blog.nav.partials.detail')
    @endforeach
@endif
</details>
