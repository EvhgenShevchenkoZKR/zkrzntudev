@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Створити посилання</h1>

    {!! Form::open(['url' => "adm/massonry/$massonry->id/edit", 'method' => 'PATCH', 'class' => 'form', 'files' => 'true']) !!}

    <div class="form-group">
        <div class="fg-streight left col-md-6">
            {!! Form::label('title', 'Титло', ['class' => 'required']) !!}
            {!! Form::text('title', $massonry->title, ['class' => 'form-control']) !!}
        </div>
        <div class="fg-streight right col-md-6">
            {!! Form::label('url', 'URL', ['class' => 'required']) !!}
            {!! Form::text('url', $massonry->url, array('class' => 'form-control')) !!}
        </div>
    </div>
    <div class="wrapper clearfix">
        <div class="form-group fg-streight left col-md-6">
            <div class="old-image old-photo">
                {!! Form::label('Поточне Фото') !!}
                <img src="/images/massonry/{{$massonry->id}}/small_{{$massonry->image}}"/>
            </div>
            <div class="form-group fg-streight right">
                {!! Form::label('Змінити Зображення') !!}
                {!! Form::file('image', array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="form-group fg-streight right col-md-6">
            {!! Form::label('Альт зображення') !!}
            {!! Form::text('image_alt', $massonry->image_alt, ['class' => 'form-control']) !!}

            {!! Form::label('Титло зображення') !!}
            {!! Form::text('image_title', $massonry->image_title, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('Текст новини') !!}
        {!! Form::textarea('body', $massonry->body, ['class' => 'form-control my-editor']) !!}
    </div>

    <div class="form-group published-inline col-md-4">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, $massonry->published, array('class' => 'form-control')) !!}
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
        $('textarea.my-editor').ckeditor({
            filebrowserBrowseUrl: '/elfinder/ckeditor',
        });
    </script>
@endsection