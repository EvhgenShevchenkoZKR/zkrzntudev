@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Створити анкету співробітника</h1>

    {!! Form::open(['url' => 'adm/employee/add', 'method' => 'POST', 'class' => 'form', 'files' => 'true']) !!}

    <div class="image-wrapper-zone clearfix">
    <div class="form-group fg-streight left col-md-6">
        {!! Form::label('fio', 'ПІБ', ['class' => 'required']) !!}
        {!! Form::text('fio', old('fio'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group fg-streight right col-md-6">
        {!! Form::label('Фото') !!}
        {!! Form::file('photo', array('class' => 'form-control')) !!}
    </div>
    </div>
    <div class="form-group">
        {!! Form::label('Посада') !!}
        {!! Form::text('position', old('position'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group clearfix">
        {!! Form::label('body', 'Опис', ['class' => 'required']) !!}
        {!! Form::textarea('body', old('body'), ['class' => 'form-control cke-text']) !!}
    </div>

    <div class="form-group published-inline col-md-4">
        {!! Form::label('Адміністрація') !!}
        {!! Form::checkbox('administration', 1, true, array('class' => 'form-control')) !!}
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