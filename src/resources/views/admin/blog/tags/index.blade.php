@extends('basic::admin.layouts.blog')

@section('blogpage-content')

    @if (Session::has('tagdeleted'))
    <div class="alert alert-alternate">{{ Session::get('tagdeleted') }}</div>
    @endif
    @if (Session::has('tagedited'))
    <div class="alert alert-alternate">{{ Session::get('tagedited') }}</div>
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
        <table class="grid-table tagtable">
            <thead>
                <tr>
                    <th>
                        ID
                        <a href="{{ route('admin.blog.tags',UrlParams::addArr(['order'=>'id','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['id'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.name') }}
                        <a href="{{ route('admin.blog.tags',UrlParams::addArr(['order'=>'name','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['name'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.created') }}
                        <a href="{{ route('admin.blog.tags',UrlParams::addArr(['order'=>'created_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['created_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th>
                        {{ __('basic::elf.updated') }}
                        <a href="{{ route('admin.blog.tags',UrlParams::addArr(['order'=>'updated_at','trend'=>['desc','asc']])) }}" class="ordering @if (UrlParams::case('order',['updated_at'=>true])) {{UrlParams::case('trend',['desc'=>'desc'],'asc')}} @endif"></a>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($tags as $tag)
                <tr data-id="{{ $tag->id }}" class="@empty ($tag->active) inactive @endempty">
                    <td>{{ $tag->id }}</td>
                    <td>
                        <a href="{{ route('admin.blog.tags.edit',$tag->id) }}">
                            {{ $tag->name }}
                        </a>
                    </td>
                    <td>{{ $tag->created_at }}</td>
                    <td>{{ $tag->updated_at }}</td>
                    <td class="button-column">
                        <a href="{{ route('admin.blog.tags.edit',$tag->id) }}" class="default-btn edit-button">{{ __('basic::elf.edit') }}</a>
                        <form action="{{ route('admin.blog.tags.destroy',$tag->id) }}" method="POST" data-submit="check">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $tag->id }}">
                            <input type="hidden" name="name" value="{{ $tag->name }}">
                            <button type="submit" class="default-btn delete-button">{{ __('basic::elf.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{$tags->links('basic::admin.layouts.pagination')}}

    <script>
        const checkForms = document.querySelectorAll('form[data-submit="check"]')

        if (checkForms) {
            checkForms.forEach(form => {
                form.addEventListener('submit',function(e){
                    e.preventDefault();
                    let tagId = this.querySelector('[name="id"]').value,
                        tagName = this.querySelector('[name="name"]').value,
                        self = this
                    popup({
                        title:'{{ __('basic::elf.deleting_of_element') }}' + tagId,
                        content:'<p>{{ __('basic::elf.are_you_sure_to_deleting_tag') }} "' + tagName + '" (ID ' + tagId + ')?</p>',
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
