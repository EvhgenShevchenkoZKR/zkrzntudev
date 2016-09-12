@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Створити тег</h1>
    {!! Form::open(array('url' => 'tags/add', 'method' => 'POST', 'class' => 'form')) !!}

    <div class="form-group">
        {!! Form::label('Титло') !!}
        {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Мета Титло') !!}
        {!! Form::text('meta_title', old('meta_title'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Мета Ключові слова') !!}
        {!! Form::text('meta_keywords', old('meta_keywords'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Мета Опис') !!}
        {!! Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control', 'size' => '50x3']) !!}
    </div>

    <div class="form-group">
    {!! Form::submit('Зберегти', ['class' => 'btn btn-success pull-right']) !!}
    </div>
    {!! Form::close() !!}
@endsection