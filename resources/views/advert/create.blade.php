@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Створити оголошення</h1>

    {!! Form::open(['url' => 'adm/objava/add', 'method' => 'POST', 'class' => 'form', 'files' => 'true']) !!}

    <div class="form-group">
        {!! Form::label('Титло') !!}
        {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
    </div>

    <div class="image-wrapper-zone clearfix">
    <div class="form-group col-md-6">
        {!! Form::label('Зображення') !!}
        {!! Form::file('cover_image', array('class' => 'form-control')) !!}
    </div>
    <div class="alttitle-wrapper col-md-6">
        <div class="form-group">
            {!! Form::label('Альт зображення') !!}
            {!! Form::text('cover_alt', old('cover_alt'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Титло зображення') !!}
            {!! Form::text('cover_title', old('cover_title'), ['class' => 'form-control']) !!}
        </div>
    </div>
    </div>

    <div class="form-group clearfix">
        {!! Form::label('body', 'Текст оголошення', ['class' => 'required']) !!}
        {!! Form::textarea('body', old('body'), ['class' => 'form-control cke-text']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Автор оголошення') !!}
        {!! Form::text('author', old('author'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Мета титло') !!}
        {!! Form::text('meta_title', old('meta_title'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Мета ключові слова') !!}
        {!! Form::text('meta_keywords', old('meta_keywords'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Мета опис') !!}
        {!! Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control', 'size' => '50x3']) !!}
    </div>
    <div class="form-group published-inline col-md-4">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, true, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Зберегти', ['class' => 'btn btn-success pull-right']) !!}
    </div>
    {!! Form::close() !!}
@endsection

@section('footerscripts')
    <script src="/vendor/js/ckeditor_dark/ckeditor.js"></script>
    <script src="/vendor/js/ckeditor_dark/adapters/jquery.js"></script>
    <script>
        $(document).ready(function() {
            $('textarea.cke-text').ckeditor();
        });
    </script>
@endsection