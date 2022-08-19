@extends('basic::admin.layouts.blog')

@section('blogpage-content')

    <div class="table-search-box">
        <div class="table-search-result-title">
            @if (!empty($search))
                {{ __('basic::elf.search_result_for') }} "{{ $search }}" <a href="{{ route('admin.blog.posts') }}" title="{{ __('basic::elf.reset_search') }}">&#215;</a>
            @endif
        </div>
        <form action="{{ route('admin.blog.posts') }}" method="get">
            <div class="input-box">
                <label for="search">
                    {{ __('basic::elf.search') }}
                </label>
                <div class="input-wrapper">
                    <input type="text" name="search" id="search" value="{{ $search ?? '' }}" placeholder="">
                </div>
                <div class="non-text-buttons">
                    <button type="submit" class="default-btn search-button"></button>
                </div>
            </div>
        </form>
    </div>
    @if (Session::has('postdeleted'))
    <div class="alert alert-alternate">{{ Session::get('postdeleted') }}</div>
    @endif
    @if (Session::has('postedited'))
    <div class="alert alert-alternate">{{ Session::get('postedited') }}</div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="widetable-wrapper">
        @if (!empty($category))
            <div class="alert alert-alternate">
                {{ __('basic::elf.showing_results_for_category') }} <strong>#{{ $category->id }} {{ $category->name }}</strong>
            </div>
        @endif
        <table class="grid-table posttable">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.blog.posts',UrlParams::addArr(['order'=>'id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.name') }}
                        <a href="{{ route('admin.blog.posts',UrlParams::addArr(['order'=>'name','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['name'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.slug') }}
                        <a href="{{ route('admin.blog.posts',UrlParams::addArr(['order'=>'slug','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['slug'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.category') }}
                        <a href="{{ route('admin.blog.posts',UrlParams::addArr(['order'=>'category_id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['category_id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                {{-- <th>{{ __('basic::elf.preview') }}</th>
                    <th>{{ __('basic::elf.image') }}</th> --}}
                    <th>
                        {{ __('basic::elf.created') }}
                        <a href="{{ route('admin.blog.posts',UrlParams::addArr(['order'=>'created_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['created_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.updated') }}
                        <a href="{{ route('admin.blog.posts',UrlParams::addArr(['order'=>'updated_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['updated_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.public_time') }}
                        <a href="{{ route('admin.blog.posts',UrlParams::addArr(['order'=>'public_time','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['public_time'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.end_time') }}
                        <a href="{{ route('admin.blog.posts',UrlParams::addArr(['order'=>'end_time','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['end_time'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.active') }}
                        <a href="{{ route('admin.blog.posts',UrlParams::addArr(['order'=>'active','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['active'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($posts as $post)
                <tr data-id="{{ $post->id }}" class="@empty ($post->active) inactive @endempty">
                    <td>{{ $post->id }}</td>
                    <td>
                        <a href="{{ route('admin.blog.posts.edit',$post->id) }}">
                            {{ $post->name }}
                        </a>
                    </td>
                    <td>{{ $post->slug }}</td>
                    <td>
                        <a href="{{ route('admin.blog.posts',UrlParams::addArr(['category'=>$post->category->id])) }}">
                            #{{ $post->category->id }} {{ $post->category->name }}
                        </a>
                    </td>
                {{-- <td class="image-cell">
                        <img src="{{ asset($post->preview) }}" alt="">
                    </td>
                    <td class="image-cell">
                        <img src="{{ asset($post->image) }}" alt="">
                    </td> --}}
                    <td>{{ $post->created_at }}</td>
                    <td>{{ $post->updated_at }}</td>
                    <td>{{ $post->public_time }}</td>
                    <td>{{ $post->end_time }}</td>
                    <td>
                    @if ($post->active)
                        {{ __('basic::elf.active') }}
                    @else
                        {{ __('basic::elf.not_active') }}
                    @endif
                    </td>
                    <td class="button-column non-text-buttons">
                        <a href="{{ route('admin.blog.posts.edit',$post->id) }}" class="default-btn edit-button" title="{{ __('basic::elf.add_post') }}"></a>
                        <form action="{{ route('admin.blog.posts.update',$post->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="id" value="{{ $post->id }}">
                            <input type="hidden" name="active" id="active" value="{{ (int)!(bool)$post->active }}">
                            <input type="hidden" name="notedit" value="1">
                            <button type="submit" @if ($post->active == 1) class="default-btn deactivate-button" title="{{__('basic::elf.deactivate') }}" @else class="default-btn activate-button" title="{{ __('basic::elf.activate') }}" @endif></button>
                        </form>
                        <form action="{{ route('admin.blog.posts.destroy',$post->id) }}" method="POST" data-submit="check">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $post->id }}">
                            <input type="hidden" name="name" value="{{ $post->name }}">
                            <button type="submit" class="default-btn delete-button" title="{{ __('basic::elf.delete') }}"></button>
                        </form>
                        <div class="contextmenu-content-box">
                            <a href="{{ route('admin.blog.posts.edit',$post->id) }}" class="contextmenu-item">{{ __('basic::elf.edit') }}</a>
                            <form action="{{ route('admin.blog.posts.update',$post->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" id="id" value="{{ $post->id }}">
                                <input type="hidden" name="active" id="active" value="{{ (int)!(bool)$post->active }}">
                                <input type="hidden" name="notedit" value="1">
                                <button type="submit" class="contextmenu-item">
                                @if ($post->active == 1)
                                    {{ __('basic::elf.deactivate') }}
                                @else
                                    {{ __('basic::elf.activate') }}
                                @endif
                                </button>
                            </form>
                            <form action="{{ route('admin.blog.posts.destroy',$post->id) }}" method="POST" data-submit="check">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $post->id }}">
                                <input type="hidden" name="name" value="{{ $post->name }}">
                                <button type="submit" class="contextmenu-item">{{ __('basic::elf.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if (empty(count($posts)))
            <div class="no-results-box">
                {{ __('basic::elf.nothing_was_found') }}
            </div>
        @endif
    </div>
    {{$posts->links('admin.layouts.pagination')}}

    <script>
        const checkForms = document.querySelectorAll('form[data-submit="check"]')

        /* if (checkForms) {
            checkForms.forEach(form => {
                form.addEventListener('submit',function(e){
                    e.preventDefault();
                    let postId = this.querySelector('[name="id"]').value,
                        postName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title:'{{ __('basic::elf.deleting_of_element') }}' + postId,
                        content:'<p>{{ __('basic::elf.are_you_sure_to_deleting_post') }} "' + postName + '" (ID ' + postId + ')?</p>',
                        buttons:[
                            {
                                title:'{{ __('basic::elf.delete') }}',
                                class:'default-btn delete-button',
                                callback: function(){
                                    self.submit()
                                }
                            },
                            {
                                title:'{{ __('basic::elf.cancel') }}',
                                class:'default-btn cancel-button',
                                callback:'close'
                            }
                        ],
                        class:'danger'
                    })
                })
            })
        } */

        function setConfirmDelete(forms) {
            if (forms) {
                forms.forEach(form => {
                    form.addEventListener('submit',function(e){
                        e.preventDefault();
                        let postId = this.querySelector('[name="id"]').value,
                            postName = this.querySelector('[name="name"]').value,
                            self = this
                        popup({
                            title:'{{ __('basic::elf.deleting_of_element') }}' + postId,
                            content:'<p>{{ __('basic::elf.are_you_sure_to_deleting_post') }} "' + postName + '" (ID ' + postId + ')?</p>',
                            buttons:[
                                {
                                    title:'{{ __('basic::elf.delete') }}',
                                    class:'default-btn delete-button',
                                    callback: function(){
                                        self.submit()
                                    }
                                },
                                {
                                    title:'{{ __('basic::elf.cancel') }}',
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

        const tablerow = document.querySelectorAll('.posttable tbody tr');
        if (tablerow) {
            tablerow.forEach(row => {
                row.addEventListener('contextmenu',function(e){
                    e.preventDefault()
                    let content = row.querySelector('.contextmenu-content-box').cloneNode(true)
                    let forms  = content.querySelectorAll('form[data-submit="check"]')
                    setConfirmDelete(forms)
                    contextPopup(content,{'left':e.x,'top':e.y})
                })
            })
        }
    </script>

@endsection
