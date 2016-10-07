@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Список цитат</h1>

    <table class="companies-atable admin-table tablesorter">
        <thead>
        <tr class="th-row">
            <th class="header">Титло</th>
            <th class="header">URL</th>
            <th class="header">Дії</th>
        </tr>
        </thead>
        @foreach($tags as $tag)
            <tr>
                <td>{{$tag->title}}</td>
                <td><a href="/tag/{{$tag->slug}}">{{$tag->slug}}</a></td>
                <td>
                    <span class="icn_edit">
                        <a class="atable-button" href="/tag/{{$tag->id}}/edit">&nbsp;</a>
                    </span>
                    <span class="icn_trash">
                    {{ Form::open(['url' => "/tag/$tag->id/delete", 'method' => 'DELETE']) }}
                        {{ Form::submit('&nbsp;', ['class' => 'btn-delete']) }}
                        {{ Form::close() }}
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
@endsection