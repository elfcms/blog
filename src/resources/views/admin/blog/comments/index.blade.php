@extends('basic::admin.layouts.blog')

@section('blogpage-content')

    @if (Session::has('commentdeleted'))
    <div class="alert alert-alternate">{{ Session::get('commentdeleted') }}</div>
    @endif
    @if (Session::has('commentedited'))
    <div class="alert alert-alternate">{{ Session::get('commentedited') }}</div>
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
        @if (!empty($post))
            <div class="alert alert-alternate">
                {{ __('basic::elf.showing_results_for_post') }} <strong>#{{ $post->id }} {{ $post->name }}</strong>
            </div>
        @endif
        @if (!empty($user))
            <div class="alert alert-alternate">
                {{ __('basic::elf.showing_results_for_user') }} <strong>#{{ $user->id }} {{ $user->email }}</strong>
            </div>
        @endif
        @if (!empty($parent))
            <div class="alert alert-alternate">
                {{ __('basic::elf.showing_results_for_answer_to') }} <strong>#{{ $parent->id }} {{ Str::limit($parent->text, 25) }}</strong>
            </div>
        @endif
        <table class="grid-table commenttable">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.blog.comments',UrlParams::addArr(['order'=>'id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.post') }}
                        <a href="{{ route('admin.blog.comments',UrlParams::addArr(['order'=>'post_id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['post_id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.answer_to') }}
                        <a href="{{ route('admin.blog.comments',UrlParams::addArr(['order'=>'parent_id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['parent_id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.user') }}
                        <a href="{{ route('admin.blog.comments',UrlParams::addArr(['order'=>'name','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['name'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.text') }}
                        <a href="{{ route('admin.blog.comments',UrlParams::addArr(['order'=>'text','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['text'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.created') }}
                        <a href="{{ route('admin.blog.comments',UrlParams::addArr(['order'=>'created_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['created_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.updated') }}
                        <a href="{{ route('admin.blog.comments',UrlParams::addArr(['order'=>'updated_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['updated_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.active') }}
                        <a href="{{ route('admin.blog.comments',UrlParams::addArr(['order'=>'active','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['active'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($comments as $comment)
            @php
                //dd($comment);
            @endphp
                <tr data-id="{{ $comment->id }}" class="@empty ($comment->active) inactive @endempty">
                    <td>{{ $comment->id }}</td>
                    <td>
                        <a href="{{ route('admin.blog.comments',['post'=>$comment->post->id]) }}">
                            #{{ $comment->post->id }} {{ $comment->post->name }}
                        </a>
                    </td>
                    <td>
                        @if (!empty($comment->parent_id))
                        <a href="{{ route('admin.blog.comments',['parent'=>$comment->parent_id]) }}">
                            #{{ $comment->parent_id }} ({{ Str::limit($comment->parent->text, 15) }})
                        </a>
                        @endif

                    </td>
                    <td>
                        <a href="{{ route('admin.blog.comments',['user'=>$comment->user_id]) }}">
                            {{ $comment->user->email }}
                        </a>
                    </td>
                    <td>{{ $comment->text }}</td>
                {{-- <td class="image-cell">
                        <img src="{{ asset($comment->preview) }}" alt="">
                    </td>
                    <td class="image-cell">
                        <img src="{{ asset($comment->image) }}" alt="">
                    </td> --}}
                    <td>{{ $comment->created_at }}</td>
                    <td>{{ $comment->updated_at }}</td>
                    <td>
                    @if ($comment->active)
                        {{ __('basic::elf.active') }}
                    @else
                        {{ __('basic::elf.not_active') }}
                    @endif
                    </td>
                    <td class="button-column">
                        <a href="{{ route('admin.blog.comments.edit',$comment->id) }}" class="default-btn edit-button">{{ __('basic::elf.edit') }}</a>
                        <form action="{{ route('admin.blog.comments.update',$comment->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="id" value="{{ $comment->id }}">
                            <input type="hidden" name="active" id="active" value="{{ (int)!(bool)$comment->active }}">
                            <input type="hidden" name="notedit" value="1">
                            <button type="submit" class="default-btn activate-button">
                            @if ($comment->active == 1)
                                {{ __('basic::elf.deactivate') }}
                            @else
                                {{ __('basic::elf.activate') }}
                            @endif
                            </button>
                        </form>
                        <form action="{{ route('admin.blog.comments.destroy',$comment->id) }}" method="POST" data-submit="check">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $comment->id }}">
                            <input type="hidden" name="name" value="{{ $comment->name }}">
                            <button type="submit" class="default-btn delete-button">{{ __('basic::elf.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{$comments->links('admin.layouts.pagination')}}

    <script>
        const checkForms = document.querySelectorAll('form[data-submit="check"]')

        if (checkForms) {
            checkForms.forEach(form => {
                form.addEventListener('submit',function(e){
                    e.preventDefault();
                    let commentId = this.querySelector('[name="id"]').value,
                        commentName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title:'{{ __('basic::elf.deleting_of_element') }}' + commentId,
                        content:'<p>{{ __('basic::elf.are_you_sure_to_deleting_comment') }} "' + commentName + '" (ID ' + commentId + ')?</p>',
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
    </script>

@endsection
