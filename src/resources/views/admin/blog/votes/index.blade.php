@extends('elfcms::admin.layouts.blog')

@section('blogpage-content')

    @if (Session::has('votedeleted'))
    <div class="alert alert-alternate">{{ Session::get('votedeleted') }}</div>
    @endif
    @if (Session::has('voteedited'))
    <div class="alert alert-alternate">{{ Session::get('voteedited') }}</div>
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
                {{ __('elfcms::default.showing_results_for_post') }} <strong>#{{ $post->id }} {{ $post->name }}</strong>
            </div>
        @endif
        @if (!empty($user))
            <div class="alert alert-alternate">
                {{ __('elfcms::default.showing_results_for_user') }} <strong>#{{ $user->id }} {{ $user->email }}</strong>
            </div>
        @endif
        <table class="grid-table table-cols-7" style="--first-col:65px; --last-col:100px; --minw:800px">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.blog.votes',UrlParams::addArr(['order'=>'id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.post') }}
                        <a href="{{ route('admin.blog.votes',UrlParams::addArr(['order'=>'post_id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['post_id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.user') }}
                        <a href="{{ route('admin.blog.votes',UrlParams::addArr(['order'=>'name','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['name'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.value') }}
                        <a href="{{ route('admin.blog.votes',UrlParams::addArr(['order'=>'value','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['value'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.created') }}
                        <a href="{{ route('admin.blog.votes',UrlParams::addArr(['order'=>'created_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['created_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('elfcms::default.updated') }}
                        <a href="{{ route('admin.blog.votes',UrlParams::addArr(['order'=>'updated_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['updated_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($votes as $vote)
            @php
                //dd($vote);
            @endphp
                <tr data-id="{{ $vote->id }}" class="">
                    <td>{{ $vote->id }}</td>
                    <td>
                        <a href="{{ route('admin.blog.votes',['post'=>$vote->post->id]) }}">
                            #{{ $vote->post->id }} {{ $vote->post->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.blog.votes',['user'=>$vote->user_id]) }}">
                            {{ $vote->user->email }}
                        </a>
                    </td>
                    <td>{{ $vote->value }}</td>
                    <td>{{ $vote->created_at }}</td>
                    <td>{{ $vote->updated_at }}</td>
                    <td class="button-column non-text-buttons">
                        <a href="{{ route('admin.blog.votes.edit',$vote->id) }}" class="default-btn edit-button" title="{{ __('elfcms::default.edit') }}"></a>
                        <form action="{{ route('admin.blog.votes.destroy',$vote->id) }}" method="POST" data-submit="check">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $vote->id }}">
                            <input type="hidden" name="name" value="{{ $vote->name }}">
                            <button type="submit" class="default-btn delete-button" title="{{ __('elfcms::default.delete') }}"></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{$votes->links('elfcms::admin.layouts.pagination')}}

    <script>
        const checkForms = document.querySelectorAll('form[data-submit="check"]')

        if (checkForms) {
            checkForms.forEach(form => {
                form.addEventListener('submit',function(e){
                    e.preventDefault();
                    let voteId = this.querySelector('[name="id"]').value,
                        voteName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title:'{{ __('blog::default.deleting_of_element') }}',
                        content:'<p>{{ __('blog::default.are_you_sure_to_deleting_element') }} "' + voteName + '" (ID ' + voteId + ')?</p>',
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
    </script>

@endsection
