@extends('adm')

@section('content')

    @if(Session::has('message'))
        <h3 class="alert">{{Session::get('message')}}</h3>
    @endif

    @if($errors->has())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif
    <h1 class="apage-title relative-apage-title">Створити новий слайдер</h1>

    {!! Form::open(array('url' => 'create-slider','method' => 'POST', 'class' => 'form', 'files' => true)) !!}
    <div class="form-group">
        {!! Form::label('Титул') !!}
        {!! Form::text('title', old('title'), array('class' => 'form-control', 'placeholder' => 'Title on slide')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Лінк') !!}
        {!! Form::text('url', old('url'), array('class' => 'form-control', 'placeholder' => 'Internal link')) !!}
    </div>


    <hr>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Слайд') !!}
            {!! Form::file('image[]', array('multiple'=>true, 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Альтернативна назва слайду') !!}
            {!! Form::text('alt', old('alt'), array('class' => 'form-control')) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Титул слайду') !!}
            {!! Form::text('slide_title', old('slide_title'), array('class' => 'form-control')) !!}
        </div>
    </div>
    <hr>
    <div class="form-group published-inline col-md-4">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, false, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Створити слайдер', array('class' => 'btn btn-success pull-right')) !!}
    </div>
    {!! Form::close() !!}
@endsection