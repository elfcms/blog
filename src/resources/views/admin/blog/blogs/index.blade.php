@extends('elfcms::admin.layouts.blog')

@section('blogpage-content')

    <div class="table-search-box">
        <div class="table-search-result-title">
            @if (!empty($search))
                {{ __('elfcms::default.search_result_for') }} "{{ $search }}" <a href="{{ route('admin.blog.blogs') }}" title="{{ __('elfcms::default.reset_search') }}">&#215;</a>
            @endif
        </div>
        <form action="{{ route('admin.blog.blogs') }}" method="get">
            <div class="input-box">
                <label for="search">
                    {{ __('elfcms::default.search') }}
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
    @if (Session::has('categorydeleted'))
    <div class="alert alert-alternate">{{ Session::get('categorydeleted') }}</div>
    @endif
    @if (Session::has('categoryedited'))
    <div class="alert alert-alternate">{{ Session::get('categoryedited') }}</div>
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
        <table class="grid-table blogtable">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.blog.blogs',UrlParams::addArr(['order'=>'id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.name') }}
                        <a href="{{ route('admin.blog.blogs',UrlParams::addArr(['order'=>'name','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['name'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.slug') }}
                        <a href="{{ route('admin.blog.blogs',UrlParams::addArr(['order'=>'slug','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['slug'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.created') }}
                        <a href="{{ route('admin.blog.blogs',UrlParams::addArr(['order'=>'created_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['created_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.updated') }}
                        <a href="{{ route('admin.blog.blogs',UrlParams::addArr(['order'=>'updated_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['updated_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.active') }}
                        <a href="{{ route('admin.blog.blogs',UrlParams::addArr(['order'=>'active','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['active'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($blogs as $blog)
                <tr data-id="{{ $blog->id }}" @class(['inactive'=>$blog->active])>
                    <td>{{ $blog->id }}</td>
                    <td>
                        <a href="{{ route('admin.blog.blogs.edit',$blog->id) }}">
                            {{ $blog->name }}
                        </a>
                    </td>
                    <td>{{ $blog->slug }}</td>
                    <td>{{ $blog->created_at }}</td>
                    <td>{{ $blog->updated_at }}</td>
                    <td>
                    @if ($blog->active)
                        {{ __('elfcms::default.active') }}
                    @else
                        {{ __('elfcms::default.not_active') }}
                    @endif
                    </td>
                    <td class="button-column non-text-buttons">
                        <form action="{{ route('admin.blog.posts.create') }}" method="GET">
                            <input type="hidden" name="category_id" value="{{ $blog->id }}">
                            <button type="submit" class="default-btn submit-button create-button" title="{{ __('elfcms::default.add_post') }}"></button>
                        </form>
                        <a href="{{ route('admin.blog.blogs.edit',$blog->id) }}" class="default-btn edit-button" title="{{ __('elfcms::default.edit') }}"></a>
                        <form action="{{ route('admin.blog.blogs.update',$blog->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="id" value="{{ $blog->id }}">
                            <input type="hidden" name="active" id="active" value="{{ (int)!(bool)$blog->active }}">
                            <input type="hidden" name="notedit" value="1">
                            <button type="submit" @if ($blog->active == 1) class="default-btn deactivate-button" title="{{__('elfcms::default.deactivate') }}" @else class="default-btn activate-button" title="{{ __('elfcms::default.activate') }}" @endif>
                            </button>
                        </form>
                        <form action="{{ route('admin.blog.blogs.destroy',$blog->id) }}" method="POST" data-submit="check">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $blog->id }}">
                            <input type="hidden" name="name" value="{{ $blog->name }}">
                            <button type="submit" class="default-btn delete-button" title="{{ __('elfcms::default.delete') }}"></button>
                        </form>
                        <div class="contextmenu-content-box">
                            <a href="{{ route('admin.blog.posts',UrlParams::addArr(['category'=>$blog->id])) }}" class="contextmenu-post">
                                {{ __('elfcms::default.show_posts') }}
                            </a>
                            <form action="{{ route('admin.blog.posts.create') }}" method="GET">
                                <input type="hidden" name="category_id" value="{{ $blog->id }}">
                                <button type="submit" class="contextmenu-post">{{ __('elfcms::default.add_post') }}</button>
                            </form>
                            <a href="{{ route('admin.blog.blogs.edit',$blog->id) }}" class="contextmenu-post">{{ __('elfcms::default.edit') }}</a>
                            <form action="{{ route('admin.blog.blogs.update',$blog->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" id="id" value="{{ $blog->id }}">
                                <input type="hidden" name="active" id="active" value="{{ (int)!(bool)$blog->active }}">
                                <input type="hidden" name="notedit" value="1">
                                <button type="submit" class="contextmenu-post">
                                @if ($blog->active == 1)
                                    {{ __('elfcms::default.deactivate') }}
                                @else
                                    {{ __('elfcms::default.activate') }}
                                @endif
                                </button>
                            </form>
                            <form action="{{ route('admin.blog.blogs.destroy',$blog->id) }}" method="POST" data-submit="check">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $blog->id }}">
                                <input type="hidden" name="name" value="{{ $blog->name }}">
                                <button type="submit" class="contextmenu-post">{{ __('elfcms::default.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if (empty(count($blogs)))
            <div class="no-results-box">
                {{ __('elfcms::default.nothing_was_found') }}
            </div>
        @endif
    </div>

    <script>
        const checkForms = document.querySelectorAll('form[data-submit="check"]')

        /* if (checkForms) {
            checkForms.forEach(form => {
                form.addEventListener('submit',function(e){
                    e.preventDefault();
                    let categoryId = this.querySelector('[name="id"]').value,
                        categoryName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title:'{{ __('elfcms::default.deleting_of_element') }}' + categoryId,
                        content:'<p>{{ __('elfcms::default.are_you_sure_to_deleting_category') }} "' + categoryName + '" (ID ' + categoryId + ')?</p>',
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
        } */

        function setConfirmDelete(forms) {
            if (forms) {
                forms.forEach(form => {
                    form.addEventListener('submit',function(e){
                        e.preventDefault();
                        let categoryId = this.querySelector('[name="id"]').value,
                            categoryName = this.querySelector('[name="name"]').value,
                            self = this
                        popup({
                            title:'{{ __('elfcms::default.deleting_of_element') }}' + categoryId,
                            content:'<p>{{ __('elfcms::default.are_you_sure_to_deleting_category') }} "' + categoryName + '" (ID ' + categoryId + ')?</p>',
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

        const tablerow = document.querySelectorAll('.categorytable tbody tr');
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
