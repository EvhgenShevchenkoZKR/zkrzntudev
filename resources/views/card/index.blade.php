@extends('app')

@section('content')
    <h1 class="page-header">Cards page</h1>
    @if($cards)
        @foreach($cards as $card)
            <div class="card-wrapper">
                <a href="card/{{$card->id}}"><h4 class="card-label">{{$card->title}}</h4></a>
                <div class="card-body">{{$card->body}}</div>
                <div class="card-image"><img src="{{url("images/cards")}}/{{$card->id}}/{{$card->image}}"></div>
            </div>
        @endforeach
    @endif

    {!! Form::open(array('url' => 'cards', 'method' => 'POST', 'class' => 'form', 'files' => true)) !!}

    <div class="form-group">
        {!! Form::label('Title') !!}
        {!! Form::text('title', null, array('class' => 'form-control', 'placeholder'=>'Card title')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Body') !!}
        {!! Form::textarea('body', null, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Image') !!}
        {!! Form::file('image', null, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Create Card', array('class' => 'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
@endsection