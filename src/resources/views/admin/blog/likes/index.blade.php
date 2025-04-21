@extends('elfcms::admin.layouts.main')

@section('pagecontent')
    {{-- <div class="table-search-box">
        <a href="{{ route('admin.blog.likes.create') }}" class="button round-button theme-button">
            {!! iconHtmlLocal('elfcms/admin/images/icons/plus.svg', svg: true) !!}
            <span class="button-collapsed-text">
                {{ __('blog::default.create_like') }}
            </span>
        </a>
    </div>
 --}}
    @if (!empty($post))
        <div class="alert alert-alternate">
            {{ __('elfcms::default.showing_results_for_post') }} <strong>#{{ $post->id }} {{ $post->name }}</strong>
        </div>
    @endif
    @if (!empty($user))
        <div class="alert alert-alternate">
            {{ __('elfcms::default.showing_results_for_user') }} <strong>#{{ $user->id }} {{ $user->email }}</strong>
        </div>
    @endif
    <div class="grid-table-wrapper">
        <table class="grid-table table-cols" style="--first-col:65px; --last-col:100px; --minw:800px; --cols-count:7;">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.blog.likes', UrlParams::addArr(['order' => 'id', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['id' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.post') }}
                        <a href="{{ route('admin.blog.likes', UrlParams::addArr(['order' => 'post_id', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['post_id' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.user') }}
                        <a href="{{ route('admin.blog.likes', UrlParams::addArr(['order' => 'name', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['name' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.value') }}
                        <a href="{{ route('admin.blog.likes', UrlParams::addArr(['order' => 'value', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['value' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.created') }}
                        <a href="{{ route('admin.blog.likes', UrlParams::addArr(['order' => 'created_at', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['created_at' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.updated') }}
                        <a href="{{ route('admin.blog.likes', UrlParams::addArr(['order' => 'updated_at', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['updated_at' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($likes as $like)
                    @php
                        //dd($like);
                    @endphp
                    <tr data-id="{{ $like->id }}" class="">
                        <td>{{ $like->id }}</td>
                        <td>
                            <a href="{{ route('admin.blog.posts.edit', ['post' => $like->post]) }}">
                                #{{ $like->post->id }} {{ $like->post->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.user.users.edit', ['user' => $like->user]) }}">
                                {{ $like->user->email }}
                            </a>
                        </td>
                        <td>{{ $like->value }}</td>
                        <td>{{ $like->created_at }}</td>
                        <td>{{ $like->updated_at }}</td>
                        <td class="button-column non-text-buttons">
                            <a href="{{ route('admin.blog.likes.edit', $like->id) }}" class="button icon-button"
                                title="{{ __('elfcms::default.edit') }}">
                                {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/edit.svg', svg: true) !!}
                            </a>
                            <form action="{{ route('admin.blog.likes.destroy', $like->id) }}" method="POST"
                                data-submit="check">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $like->id }}">
                                <input type="hidden" name="name" value="{{ $like->name }}">
                                <button type="submit" class="button icon-button icon-alarm-button"
                                    title="{{ __('elfcms::default.delete') }}">
                                    {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/delete.svg', svg: true) !!}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $likes->links('elfcms::admin.layouts.pagination') }}

    <script>
        const checkForms = document.querySelectorAll('form[data-submit="check"]')

        if (checkForms) {
            checkForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let likeId = this.querySelector('[name="id"]').value,
                        likeName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title: '{{ __('blog::default.deleting_of_element') }}',
                        content: '<p>{{ __('blog::default.are_you_sure_to_deleting_element') }} (ID ' +
                            likeId + ')</p>',
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
    </script>
@endsection
