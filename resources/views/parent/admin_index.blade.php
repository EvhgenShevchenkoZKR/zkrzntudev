@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Список Базових сторінок</h1>
    <table class="companies-atable admin-table tablesorter">
        <thead>
        <tr>
            <th class="header">Титло</th>
            <th class="header">Лінк</th>
            <th class="header">Опубліковано</th>
            <th class="header">Дії</th>
        </tr>
        </thead>
        @foreach($parents as $parent)
            <tr>
                <td>{{$parent->title}}</td>
                <td>{{$parent->slug}}</td>
                @if($parent->published == false)
                    <td>
                    <span class="ared">Ні</span>
                        <span class="icn_photo">
                        <a class="atable-button a-unpublish" href="/adm/parent/{{$parent->id}}/publish">&nbsp;</a>
                        </span>
                    </td>
                @else
                    <td>
                    <span class="agreen">Так</span>
                    <span class="icn_security">
                    <a class="atable-button a-unpublish" href="/adm/parent/{{$parent->id}}/unpublish">&nbsp;</a>
                    </span>
                    </td>
                @endif
                <td>
                    <span class="icn_edit">
                        <a class="atable-button" href="/adm/parent/{{$parent->id}}/edit">&nbsp;</a>
                    </span>
                    <span class="icn_trash">
                        {{ Form::open(['url' => "adm/parent/$parent->id/delete", 'method' => 'DELETE']) }}
                        {{ Form::submit('&nbsp;', ['class' => 'btn-delete']) }}
                        {{ Form::close() }}
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $parents->render() }}
@endsection