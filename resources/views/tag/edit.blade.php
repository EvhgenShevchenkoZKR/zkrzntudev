@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Оновити тег</h1>
    {!! Form::open(array('url' => "tag/$tag->id/edit", 'method' => 'POST', 'class' => 'form')) !!}

    <div class="form-group">
        {!! Form::label('title', 'Титло', ['class' => 'required']) !!}
        {!! Form::text('title', $tag->title, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('meta_title', 'Мета Титло', ['class' => 'required']) !!}
        {!! Form::text('meta_title', $tag->meta_title, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('meta_keywords', 'Мета Ключові слова', ['class' => 'required']) !!}
        {!! Form::text('meta_keywords', $tag->meta_keywords, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('meta_description', 'Мета Опис', ['class' => 'required']) !!}
        {!! Form::textarea('meta_description', $tag->meta_description, ['class' => 'form-control', 'size' => '50x3']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Зберегти', ['class' => 'btn btn-success pull-right']) !!}
    </div>
    {!! Form::close() !!}
@endsection