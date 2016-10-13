@extends('adm')

{{--
title
url
created_at
updated_at
watch link (may be in title)
in slider (yes/no)
important (yes/no)
--}}

@section('content')
    <h1 class="apage-title relative-apage-title">Список новин</h1>
    {!! Form::open(array('url' => 'adm/news-search', 'method' => 'POST', 'class' => 'form search-form clearfix' )) !!}
    @if(empty($search))
        @php $search = ''; @endphp
    @endif
    <div class="form-group col-md-6">
        {!! Form::label('search', 'Шукати новину', ['class' => 'inline']) !!}
        {!! Form::text('search', $search, ['class' => 'form-control text-inline']) !!}
    </div>
    <div class="form-group col-md-6">
        {!! Form::submit('Шукати', ['class' => 'btn btn-success']) !!}
    </div>
    {!! Form::close() !!}
    <table class="companies-atable admin-table tablesorter">
        <thead>
        <tr>
            <th class="header">Титло</th>
            <th class="header">Лінк</th>
            <th class="header">Створено</th>
            <th class="header">Змінено</th>
            <th class="header">В слайдері</th>
            <th class="header">Важливо</th>
            <th class="header">Видно</th>
            <th class="header">Дії</th>
        </tr>
        </thead>
        @foreach($news as $single_news)
            <tr>
                {{-- Title column --}}
                <td>{{$single_news->title}}</td>
                {{--Link column --}}
                @if($single_news->author_name != 'Життя коледжу')
                <td><a href="/news/{{$single_news->slug}}">news/{{$single_news->slug}}</a></td>
                @else
                <td><a href="/tvorchist/{{$single_news->slug}}">tvorchist/{{$single_news->slug}}</a></td>
                @endif
                {{--Created column --}}
                <td>
                    {{ date('H:i', strtotime($single_news->created_at)) }}
                    <br>
                    {{ date('d.m.y', strtotime($single_news->created_at)) }}
                </td>
                {{--Updated column --}}
                <td>
                    {{ date('H:i', strtotime($single_news->updated_at)) }}
                    <br>
                    {{ date('d.m.y', strtotime($single_news->updated_at)) }}
                </td>
                {{--In slider column --}}
                @if($single_news->cover_show == false)
                    <td><span class="ared">Ні</span></td>
                @else
                    <td><span class="agreen">Так</span></td>
                @endif

                {{--Important column --}}
                @if($single_news->important == false)
                    <td><span class="ared">Ні</span></td>
                @else
                    <td><span class="agreen">Так</span></td>
                @endif

                {{--Published column --}}
                @if($single_news->published == false)
                    <td>
                    <span class="ared">Ні</span>
                        <span class="icn_photo">
                        <a class="atable-button a-unpublish" href="/adm/news/{{$single_news->id}}/publish">&nbsp;</a>
                        </span>
                    </td>
                @else
                    <td>
                    <span class="agreen">Так</span>
                    <span class="icn_security">
                    <a class="atable-button a-unpublish" href="/adm/news/{{$single_news->id}}/unpublish">&nbsp;</a>
                    </span>
                    </td>
                @endif
                <td>
                    <span class="icn_edit">
                        <a class="atable-button" href="/adm/news/{{$single_news->id}}/edit">&nbsp;</a>
                    </span>
                    <span class="icn_trash">
                        {{ Form::open(['url' => "/news/$single_news->id/delete", 'method' => 'DELETE']) }}
                        {{ Form::submit('&nbsp;', ['class' => 'btn-delete']) }}
                        {{ Form::close() }}
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
    @if(method_exists($news,'render'))
        {{ $news->render() }}
    @endif
@endsection