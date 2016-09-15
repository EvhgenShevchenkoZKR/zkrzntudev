@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Створити цитату</h1>

    {!! Form::open(['url' => 'adm/quote/add', 'method' => 'POST', 'class' => 'form']) !!}

    <div class="form-group">
        {!! Form::label('body', 'Текст цитати', ['class' => 'required']) !!}
        {!! Form::textarea('body', old('body'), ['class' => 'form-control cke-body']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Автор цитати') !!}
        {!! Form::text('author', old('author'), ['class' => 'form-control']) !!}
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
            $('textarea.cke-body').ckeditor();
        });
    </script>
@endsection