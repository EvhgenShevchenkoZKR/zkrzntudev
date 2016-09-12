@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Список цитат</h1>

    <table class="companies-atable admin-table tablesorter">
        <thead>
        <tr class="th-row">
            <th class="header">Автор</th>
            <th class="header">Цитата</th>
            <th class="header">Дії</th>
        </tr>
        </thead>
        @foreach($quotes as $quote)
            <tr>
                <td>{{$quote->author}}</td>
                <td>{!! $quote->body !!}</td>
                <td>
                    <span class="icn_edit">
                        <a class="atable-button" href="/adm/quote/{{$quote->id}}/edit">&nbsp;</a>
                    </span>
                    <span class="icn_trash">
                        {{ Form::open(['url' => "adm/quote/$quote->id/delete", 'method' => 'DELETE']) }}
                        {{ Form::submit('&nbsp;', ['class' => 'btn-delete']) }}
                        {{ Form::close() }}
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $quotes->render() }}
@endsection