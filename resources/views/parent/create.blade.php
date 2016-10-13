@extends('adm')

@section('headerstyles')
    <script src='/js/chosen/chosen.jquery.min.js'></script>
    <link rel="stylesheet" type="text/css" href="/js/chosen/chosen.min.css" />
@endsection

@section('content')
    <h1 class="apage-title relative-apage-title">Створити Базову сторінку</h1>
    {!! Form::open(array('url' => 'adm/parent/add', 'method' => 'POST', 'class' => 'form clearfix')) !!}
    <div class="hidden" id="select-something">Оберiть щось</div>
    <div class="form-group">
        {!! Form::label('title', 'Титло', ['class' => 'required']) !!}
        {!! Form::text('title', old('title'), array('class' => 'form-control')) !!}
    </div>
    <div class="form-group fg-streight left col-md-6">
        {!! Form::label('title_children', 'Титло для пов’язаних матеріалів') !!}
        {!! Form::text('title_children', old('title_children'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group fg-streight right col-md-6">
        {!! Form::label('Титло для пов’язаних новин') !!}
        {!! Form::text('title_tags', old('title_tags'), array('class' => 'form-control')) !!}
    </div>
    <div class="form-group">
        {!! Form::label('description', 'Текст Сторінки', ['class' => 'required']) !!}
        {!! Form::textarea('description', old('description'), ['class' => 'form-control my-editor']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Теги') !!}
        {!! Form::select('tags[]', $tags, null, array(
        'class' => 'form-control chosen-select',
        'multiple' => 'multiple',
        )) !!}
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
    <div class="form-group published-inline col-md-6">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, true, array('class' => 'form-control')) !!}
    </div>
    <div class="form-group">
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
            var multi_select_label = $('#select-something').html();
            $(function(){
                $(".chosen-select").chosen({
                    placeholder_text_multiple: multi_select_label
                });
            });
        });
    </script>
@endsection