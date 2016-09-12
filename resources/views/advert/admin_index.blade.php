@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Список оголошеннь</h1>
    <table class="companies-atable admin-table tablesorter">
        <thead>
        <tr>
            <th class="header">Титло</th>
            <th class="header">Автор</th>
            <th class="header">Опубліковано</th>
            <th class="header">Дії</th>
        </tr>
        </thead>
        @foreach($adverts as $single_news)
            <tr>
                <td>{{$single_news->title}}</td>
                <td>{{$single_news->author}}</td>
                @if($single_news->published == false)
                    <td>
                    <span class="ared">Ні</span>
                        <span class="icn_photo">
                        <a class="atable-button a-unpublish" href="/adm/objava/{{$single_news->id}}/publish">&nbsp;</a>
                        </span>
                    </td>
                @else
                    <td>
                    <span class="agreen">Так</span>
                    <span class="icn_security">
                    <a class="atable-button a-unpublish" href="/adm/objava/{{$single_news->id}}/unpublish">&nbsp;</a>
                    </span>
                    </td>
                @endif
                <td>
                    <span class="icn_edit">
                        <a class="atable-button" href="/adm/objava/{{$single_news->id}}/edit">&nbsp;</a>
                    </span>
                    <span class="icn_trash">
                        {{ Form::open(['url' => "/adm/objava/$single_news->id/delete", 'method' => 'DELETE']) }}
                        {{ Form::submit('&nbsp;', ['class' => 'btn-delete']) }}
                        {{ Form::close() }}
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $adverts->render() }}
@endsection