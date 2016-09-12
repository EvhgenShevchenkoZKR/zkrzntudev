@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Створити анкету співробітника</h1>

    {!! Form::open(['url' => "adm/employee/$employee->id/edit", 'method' => 'PATCH', 'class' => 'form', 'files' => 'true']) !!}

    <div class="image-wrapper-zone clearfix">
    <div class="form-group">
        {!! Form::label('fio', 'ПІБ', ['class' => 'required']) !!}
        {!! Form::text('fio', $employee->fio, ['class' => 'form-control']) !!}
    </div>

    <div class="image-wrapper-zone clearfix">
        <div class="old-image old-photo col-md-6">
            {!! Form::label('Поточне Фото') !!}
            <img src="/images/employees/{{$employee->id}}/photo_{{$employee->photo}}"/>
        </div>
        <div class="form-group fg-streight right col-md-6">
            {!! Form::label('Змінити Фото') !!}
            {!! Form::file('photo', array('class' => 'form-control')) !!}
        </div>
    </div>

    </div>
    <div class="form-group">
        {!! Form::label('Посада') !!}
        {!! Form::text('position', $employee->position, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group clearfix">
        {!! Form::label('body', 'Опис', ['class' => 'required']) !!}
        {!! Form::textarea('body', $employee->body, ['class' => 'form-control cke-text']) !!}
    </div>

    <div class="form-group published-inline col-md-4">
        {!! Form::label('Адміністрація') !!}
        {!! Form::checkbox('administration', 1, $employee->administration, array('class' => 'form-control')) !!}
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