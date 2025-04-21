@extends('elfcms::admin.layouts.main')

@section('pagecontent')
    <div class="table-search-box">
        <a href="{{ route('admin.blog.posts.create') }}" class="button round-button theme-button">
            {!! iconHtmlLocal('elfcms/admin/images/icons/plus.svg', svg: true) !!}
            <span class="button-collapsed-text">
                {{ __('elfcms::default.create_post') }}
            </span>
        </a>
        <form action="{{ route('admin.blog.posts') }}" method="get">
            <div class="round-input-wrapper">
                <button type="submit" class="button round-button theme-button inner-button default-highlight-button">
                    {!! iconHtmlLocal('elfcms/admin/images/icons/search.svg', width: 18, height: 18, svg: true) !!}
                </button>
                <input type="search" name="search" id="search" value="{{ $search ?? '' }}" placeholder="">
            </div>
        </form>
        <div class="table-search-result-title">
            @if (!empty($search))
                {{ __('elfcms::default.search_result_for') }} "{{ $search }}" <a
                    href="{{ route('admin.blog.posts') }}" title="{{ __('elfcms::default.reset_search') }}">&#215;</a>
            @endif
        </div>
    </div>
    @if (!empty($category))
        <div class="alert alert-standard">
            {{ __('elfcms::default.showing_results_for_category') }} <strong>#{{ $category->id }}
                {{ $category->name }}</strong>
        </div>
    @endif
    <div class="grid-table-wrapper">
        <table class="grid-table table-cols" style="--first-col:4rem; --last-col:11rem; --minw:50rem; --cols-count:10;">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.blog.posts', UrlParams::addArr(['order' => 'id', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['id' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.name') }}
                        <a href="{{ route('admin.blog.posts', UrlParams::addArr(['order' => 'name', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['name' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.slug') }}
                        <a href="{{ route('admin.blog.posts', UrlParams::addArr(['order' => 'slug', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['slug' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.category') }}
                        <a href="{{ route('admin.blog.posts', UrlParams::addArr(['order' => 'category_id', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['category_id' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    {{-- <th>{{ __('elfcms::default.preview') }}</th>
                    <th>{{ __('elfcms::default.image') }}</th> --}}
                    <th>
                        {{ __('elfcms::default.created') }}
                        <a href="{{ route('admin.blog.posts', UrlParams::addArr(['order' => 'created_at', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['created_at' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.updated') }}
                        <a href="{{ route('admin.blog.posts', UrlParams::addArr(['order' => 'updated_at', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['updated_at' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.public_time') }}
                        <a href="{{ route('admin.blog.posts', UrlParams::addArr(['order' => 'public_time', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['public_time' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.end_time') }}
                        <a href="{{ route('admin.blog.posts', UrlParams::addArr(['order' => 'end_time', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['end_time' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.active') }}
                        <a href="{{ route('admin.blog.posts', UrlParams::addArr(['order' => 'active', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['active' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr data-id="{{ $post->id }}" class="@empty($post->active) inactive @endempty">
                        <td>{{ $post->id }}</td>
                        <td>
                            <a href="{{ route('admin.blog.posts.edit', $post->id) }}">
                                {{ $post->name }}
                            </a>
                        </td>
                        <td>{{ $post->slug }}</td>
                        <td>
                            @if (!empty($post->category))
                                <a
                                    href="{{ route('admin.blog.posts', UrlParams::addArr(['category' => $post->category->id])) }}">
                                    #{{ $post->category->id }} {{ $post->category->name }}
                                </a>
                            @endif
                        </td>
                        <td>{{ $post->created_at }}</td>
                        <td>{{ $post->updated_at }}</td>
                        <td>{{ $post->public_time }}</td>
                        <td>{{ $post->end_time }}</td>
                        <td>
                            @if ($post->active)
                                {{ __('elfcms::default.active') }}
                            @else
                                {{ __('elfcms::default.not_active') }}
                            @endif
                        </td>
                        <td class="button-column non-text-buttons">
                            <a href="{{ route('admin.blog.posts.edit', $post) }}" class="button icon-button"
                                title="{{ __('elfcms::default.add_post') }}">
                                {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/edit.svg', svg: true) !!}
                            </a>
                            <form action="{{ route('admin.blog.posts.update', $post) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" id="id" value="{{ $post->id }}">
                                <input type="hidden" name="active" id="active"
                                    value="{{ (int) !(bool) $post->active }}">
                                <input type="hidden" name="notedit" value="1">
                                @if ($post->active == 1)
                                    <button type="submit" class="button icon-button"
                                        title="{{ __('elfcms::default.deactivate') }}">
                                        {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/article_active.svg', svg: true) !!}
                                    </button>
                                @else
                                    <button type="submit" class="button icon-button"
                                        title="{{ __('elfcms::default.activate') }}">
                                        {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/article_inactive.svg', svg: true) !!}
                                    </button>
                                @endif
                            </form>
                            <form action="{{ route('admin.blog.posts.destroy', $post) }}" method="POST"
                                data-submit="check">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $post->id }}">
                                <input type="hidden" name="name" value="{{ $post->name }}">
                                <button type="submit" class="button icon-button icon-alarm-button"
                                    title="{{ __('elfcms::default.delete') }}">
                                    {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/delete.svg', svg: true) !!}
                                </button>
                            </form>
                            {{-- <div class="contextmenu-content-box">
                                <a href="{{ route('admin.blog.posts.edit', $post->id) }}"
                                    class="contextmenu-post">{{ __('elfcms::default.edit') }}</a>
                                <form action="{{ route('admin.blog.posts.update', $post->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="id" value="{{ $post->id }}">
                                    <input type="hidden" name="active" id="active"
                                        value="{{ (int) !(bool) $post->active }}">
                                    <input type="hidden" name="notedit" value="1">
                                    <button type="submit" class="contextmenu-post">
                                        @if ($post->active == 1)
                                            {{ __('elfcms::default.deactivate') }}
                                        @else
                                            {{ __('elfcms::default.activate') }}
                                        @endif
                                    </button>
                                </form>
                                <form action="{{ route('admin.blog.posts.destroy', $post->id) }}" method="POST"
                                    data-submit="check">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $post->id }}">
                                    <input type="hidden" name="name" value="{{ $post->name }}">
                                    <button type="submit"
                                        class="contextmenu-post">{{ __('elfcms::default.delete') }}</button>
                                </form>
                            </div> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (empty(count($posts)))
            <div class="no-results-box">
                {{ __('elfcms::default.nothing_was_found') }}
            </div>
        @endif
    </div>
    {{ $posts->links('elfcms::admin.layouts.pagination') }}

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
                        title:'{{ __('elfcms::default.deleting_of_element') }}' + postId,
                        content:'<p>{{ __('elfcms::default.are_you_sure_to_deleting_post') }} "' + postName + '" (ID ' + postId + ')?</p>',
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
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        let postId = this.querySelector('[name="id"]').value,
                            postName = this.querySelector('[name="name"]').value,
                            self = this
                        popup({
                            title: '{{ __('elfcms::default.deleting_of_element') }}' + postId,
                            content: '<p>{{ __('elfcms::default.are_you_sure_to_deleting_post') }} "' +
                                postName + '" (ID ' + postId + ')?</p>',
                            buttons: [{
                                    title: '{{ __('elfcms::default.delete') }}',
                                    class: 'button color-text-button danger-button',
                                    callback: function() {
                                        self.submit()
                                    }
                                },
                                {
                                    title: '{{ __('elfcms::default.cancel') }}',
                                    class: 'button color-text-button',
                                    callback: 'close'
                                }
                            ],
                            class: 'danger'
                        })
                    })
                })
            }
        }
        setConfirmDelete(checkForms)

        /* const tablerow = document.querySelectorAll('.posttable tbody tr');
        if (tablerow) {
            tablerow.forEach(row => {
                row.addEventListener('contextmenu', function(e) {
                    e.preventDefault()
                    let content = row.querySelector('.contextmenu-content-box').cloneNode(true)
                    let forms = content.querySelectorAll('form[data-submit="check"]')
                    setConfirmDelete(forms)
                    contextPopup(content, {
                        'left': e.x,
                        'top': e.y
                    })
                })
            })
        } */
    </script>
@endsection
