@extends('adm')

@section('headerstyles')
    <script src='/js/chosen/chosen.jquery.min.js'></script>
    <link rel="stylesheet" type="text/css" href="/js/chosen/chosen.min.css" />
@endsection

@section('content')
    <h1 class="apage-title relative-apage-title">Створити новину</h1>
    {!! Form::open(array('url' => 'news/add', 'method' => 'POST', 'class' => 'form clearfix', 'files' => 'true')) !!}
    <div class="form-group">
        <div class="fg-streight left col-md-6">
            {!! Form::label('Титло') !!}
            {!! Form::text('title', old('title'), array('class' => 'form-control')) !!}
        </div>
        <div class="fg-streight right col-md-6">
            {!! Form::label('Автор') !!}
            {!! Form::text('author_name', old('author_name'), array('class' => 'form-control')) !!}
        </div>
    </div>
    <script src="/vendor/js/ckeditor_dark/ckeditor.js"></script>
    <script src="/vendor/js/ckeditor_dark/adapters/jquery.js"></script>
    <div class="form-group">
        {!! Form::label('Текст новини') !!}
        {!! Form::textarea('body', old('body'), ['class' => 'form-control my-editor']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Теги') !!}
        {!! Form::select('tags[]', $tags, null, array(
        'class' => 'form-control chosen-select',
        'multiple' => 'multiple',
        )) !!}
    </div>
    <script>
        $('textarea.my-editor').ckeditor({
            filebrowserBrowseUrl: '/elfinder/ckeditor',
        });
    </script>
    {{--<div class="form-group">--}}
        {{--{!! Form::label('Аліас') !!}--}}
        {{--{!! Form::text('slug', old('slug'), array('class' => 'form-control')) !!}--}}
    {{--</div>--}}

    <div class="form-group">
        {!! Form::label('Зображення') !!}
        {!! Form::file('cover_image', array('class' => 'form-control')) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Альт зображення') !!}
        {!! Form::text('cover_alt', old('cover_alt'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Титло зображення') !!}
        {!! Form::text('cover_title', old('cover_title'), ['class' => 'form-control']) !!}
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
    <div class="form-group published-wrapper col-md-4">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, true, array('class' => 'form-control')) !!}
    </div>
    <div class="form-group published-wrapper col-md-4">
        {!! Form::label('Важлива новина (виводиться на головній сторінці зліва)') !!}
        {!! Form::checkbox('important', 1, false, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group published-wrapper col-md-4">
        {!! Form::label('В слайдер (Виводити зображення в боковому слайдері з новинами?') !!}
        {!! Form::checkbox('cover_show', 1, true, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Зберегти', array('class' => 'btn btn-success pull-right')) !!}
    </div>
    {!! Form::close() !!}
@endsection

@section('footerscripts')
    <script>
        $(document).ready(function() {
            $(function () {
                $(".chosen-select").chosen();
            });
        });
    </script>
@endsection