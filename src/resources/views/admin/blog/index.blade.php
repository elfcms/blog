@extends('elfcms::admin.layouts.main')

@section('pagecontent')

<div class="big-container">
    {{-- <div class="bigtile-box">
        @foreach ($menuData as $data)
        <a href="{{route($data['route'])}}" class="tile-post">
            {{-- <div class="tile-image">
                <img src="{{$data['big_icon'] ?? $data['icon']}}" alt="" width="64">
            </div> --}
            <div class="tile-content">
                <h3>{{__($data['lang_title'])}}</h3>
                <div class="tile-description">
                    {{$data['text']}}
                </div>
                <div class="tile-data">
                    @foreach ($data['subdata'] as $subdata)
                    <div class="tile-data-post">
                        <div class="tile-data-post-title">{{$subdata['title']}}:</div>
                        <div class="tile-data-post-value">{{$subdata['value']}}</div>
                    </div>
                    @endforeach

                </div>
            </div>
        </a>
        @endforeach
    </div> --}}
</div>

@endsection
