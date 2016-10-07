@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Створити тег</h1>
    {!! Form::open(array('url' => 'tags/add', 'method' => 'POST', 'class' => 'form')) !!}

    <div class="form-group">
        {!! Form::label('title', 'Титло', ['class' => 'required']) !!}
        {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('meta_title', 'Мета Титло', ['class' => 'required']) !!}
        {!! Form::text('meta_title', old('meta_title'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('meta_keywords', 'Мета Ключові слова', ['class' => 'required']) !!}
        {!! Form::text('meta_keywords', old('meta_keywords'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('meta_description', 'Мета Опис', ['class' => 'required']) !!}
        {!! Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control', 'size' => '50x3']) !!}
    </div>

    <div class="form-group">
    {!! Form::submit('Зберегти', ['class' => 'btn btn-success pull-right']) !!}
    </div>
    {!! Form::close() !!}
@endsection