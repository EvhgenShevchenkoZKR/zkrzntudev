@extends('adm')

@section('headerstyles')
    <script src='/js/chosen/chosen.jquery.min.js'></script>
    <link rel="stylesheet" type="text/css" href="/js/chosen/chosen.min.css" />
@endsection

@section('content')
    <h1 class="apage-title relative-apage-title">Створити Матеріал</h1>
    {!! Form::open(array('url' => 'adm/child/add', 'method' => 'POST', 'class' => 'form clearfix', 'files' => 'true')) !!}

    <div class="fields-wrapper">
        <div class="form-group col-md-6">
            {!! Form::label('Титло') !!}
            {!! Form::text('title', old('title'), array('class' => 'form-control')) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('Відноситься до матеріалу') !!}
            {!! Form::select('parent_id', $parents, null, array(
            'class' => 'form-control chosen-select',
            )) !!}
        </div>
    </div>

    <div class="image-wrapper clearfix">
        <div class="form-group col-md-6">
            {!! Form::label('Зображення') !!}
            {!! Form::file('cover_image', array('class' => 'form-control')) !!}
        </div>
        <div class="fields-wrapper col-md-6">
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



    <div class="form-group">
        {!! Form::label('Текст Матеріалу') !!}
        {!! Form::textarea('body', old('description'), ['class' => 'form-control my-editor']) !!}
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
    {{--<div class="form-group published-wrapper col-md-4">--}}
        {{--{!! Form::label('В слайдер (Виводити зображення в боковому слайдері з новинами?') !!}--}}
        {{--{!! Form::checkbox('cover_show', 1, true, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
    <div class="form-group col-md-4">
        {!! Form::submit('Зберегти', array('class' => 'btn btn-success pull-right')) !!}
    </div>
    {!! Form::close() !!}
@endsection

@section('footerscripts')
    <script src="/vendor/js/ckeditor_dark/ckeditor.js"></script>
    <script src="/vendor/js/ckeditor_dark/adapters/jquery.js"></script>
    <script>
        $('textarea.my-editor').ckeditor({
            filebrowserBrowseUrl: '/elfinder/ckeditor',
        });
    </script>
    <script>
        $(document).ready(function() {
            $(function () {
                $(".chosen-select").chosen();
            });
        });
    </script>
@endsection