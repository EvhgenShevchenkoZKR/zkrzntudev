@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Список матеріалів</h1>
    <table class="companies-atable admin-table tablesorter">
        <thead>
        <tr>
            <th class="header">Титло</th>
            <th class="header">Лiнк</th>
            <th class="header">Зобреження</th>
            <th class="header">Належить до</th>
            <th class="header">Опубліковано</th>
            <th class="header">Дії</th>
        </tr>
        </thead>
        @foreach($childs as $child)
            <tr>
                <td>{{$child->title}}</td>
                <td><a href="/child/{{$child->slug}}">/child/{{$child->slug}}</a></td>
                <td><img src="/images/child/{{$child->id}}/thumbnail_{{$child->cover_image}}"/></td>
                @if(isset($child->parent->title))
                    <td>{{$child->parent->title}}</td>
                @else
                    <td></td>
                @endif
                @if($child->published == false)
                    <td>
                    <span class="ared">Ні</span>
                        <span class="icn_photo">
                        <a class="atable-button a-unpublish" href="/adm/child/{{$child->id}}/publish">&nbsp;</a>
                        </span>
                    </td>
                @else
                    <td>
                    <span class="agreen">Так</span>
                    <span class="icn_security">
                    <a class="atable-button a-unpublish" href="/adm/child/{{$child->id}}/unpublish">&nbsp;</a>
                    </span>
                    </td>
                @endif
                <td>
                    <span class="icn_edit">
                        <a class="atable-button" href="/adm/child/{{$child->id}}/edit">&nbsp;</a>
                    </span>
                    <span class="icn_trash">
                        {{ Form::open(['url' => "/adm/child/$child->id/delete", 'method' => 'DELETE']) }}
                        {{ Form::submit('&nbsp;', ['class' => 'btn-delete']) }}
                        {{ Form::close() }}
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
    {{--{{ $child->render() }}--}}
@endsection