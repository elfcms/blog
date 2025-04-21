@extends('elfcms::admin.layouts.main')

@section('pagecontent')
    <div class="table-search-box">
        <a href="{{ route('admin.blog.comments.create') }}" class="button round-button theme-button">
            {!! iconHtmlLocal('elfcms/admin/images/icons/plus.svg', svg: true) !!}
            <span class="button-collapsed-text">
                {{ __('blog::default.add_comment') }}
            </span>
        </a>
    </div>
    <div class="grid-table-wrapper">
        @if (!empty($post))
            <div class="alert alert-alternate">
                {{ __('elfcms::default.showing_results_for_post') }} <strong>#{{ $post->id }}
                    {{ $post->name }}</strong>
            </div>
        @endif
        @if (!empty($user))
            <div class="alert alert-alternate">
                {{ __('elfcms::default.showing_results_for_user') }} <strong>#{{ $user->id }}
                    {{ $user->email }}</strong>
            </div>
        @endif
        @if (!empty($parent))
            <div class="alert alert-alternate">
                {{ __('elfcms::default.showing_results_for_answer_to') }} <strong>#{{ $parent->id }}
                    {{ Str::limit($parent->text, 25) }}</strong>
            </div>
        @endif
        <table class="grid-table table-cols" style="--first-col:65px; --last-col:140px; --minw:800px; --cols-count:9;">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.blog.comments', UrlParams::addArr(['order' => 'id', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['id' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.post') }}
                        <a href="{{ route('admin.blog.comments', UrlParams::addArr(['order' => 'post_id', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['post_id' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.answer_to') }}
                        <a href="{{ route('admin.blog.comments', UrlParams::addArr(['order' => 'parent_id', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['parent_id' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.user') }}
                        <a href="{{ route('admin.blog.comments', UrlParams::addArr(['order' => 'name', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['name' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.text') }}
                        <a href="{{ route('admin.blog.comments', UrlParams::addArr(['order' => 'text', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['text' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.created') }}
                        <a href="{{ route('admin.blog.comments', UrlParams::addArr(['order' => 'created_at', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['created_at' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.updated') }}
                        <a href="{{ route('admin.blog.comments', UrlParams::addArr(['order' => 'updated_at', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['updated_at' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.active') }}
                        <a href="{{ route('admin.blog.comments', UrlParams::addArr(['order' => 'active', 'trend' => ['desc', 'asc']])) }}"
                            class="ordering @if (UrlParams::case('order', ['active' => true])) {{ UrlParams::case('trend', ['desc' => 'desc'], 'asc') }} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $comment)
                    <tr data-id="{{ $comment->id }}" class="@empty($comment->active) inactive @endempty">
                        <td>{{ $comment->id }}</td>
                        <td>
                            <a href="{{ route('admin.blog.comments', ['post' => $comment->post->id]) }}">
                                #{{ $comment->post->id }} {{ $comment->post->name }}
                            </a>
                        </td>
                        <td>
                            @if (!empty($comment->parent_id))
                                <a href="{{ route('admin.blog.comments', ['parent' => $comment->parent_id]) }}">
                                    #{{ $comment->parent_id }} ({{ Str::limit($comment->parent->text, 15) }})
                                </a>
                            @endif

                        </td>
                        <td>
                            <a href="{{ route('admin.blog.comments', ['user' => $comment->user_id]) }}">
                                {{ $comment->user->email }}
                            </a>
                        </td>
                        <td>{{ $comment->text }}</td>
                        <td>{{ $comment->created_at }}</td>
                        <td>{{ $comment->updated_at }}</td>
                        <td>
                            @if ($comment->active)
                                {{ __('elfcms::default.active') }}
                            @else
                                {{ __('elfcms::default.not_active') }}
                            @endif
                        </td>
                        <td class="button-column non-text-buttons">
                            <a href="{{ route('admin.blog.comments.edit', $comment->id) }}" class="button icon-button"
                                title="{{ __('elfcms::default.edit') }}">
                                {!! iconHtmlLocal('elfcms/admin/images/icons/buttons/edit.svg', svg: true) !!}
                            </a>
                            <form action="{{ route('admin.blog.comments.update', $comment->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" id="id" value="{{ $comment->id }}">
                                <input type="hidden" name="active" id="active"
                                    value="{{ (int) !(bool) $comment->active }}">
                                <input type="hidden" name="notedit" value="1">
                                @if ($comment->active == 1)
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
                            <form action="{{ route('admin.blog.comments.destroy', $comment->id) }}" method="POST"
                                data-submit="check">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $comment->id }}">
                                <input type="hidden" name="name" value="{{ $comment->name }}">
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
    {{ $comments->links('elfcms::admin.layouts.pagination') }}

    <script>
        const checkForms = document.querySelectorAll('form[data-submit="check"]')

        if (checkForms) {
            checkForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let commentId = this.querySelector('[name="id"]').value,
                        commentName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title: '{{ __('elfcms::default.deleting_of_element') }}' + commentId,
                        content: '<p>{{ __('blog::default.are_you_sure_to_deleting_comment') }} "' +
                            commentName + '" (ID ' + commentId + ')?</p>',
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
